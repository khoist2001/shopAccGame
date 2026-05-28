<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Account;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    /**
     * View Cart Page
     */
    public function index()
    {
        $cart = session()->get('cart', []);
        
        // Refresh account details in cart to make sure prices are fresh
        $accountIds = array_keys($cart);
        $accounts = Account::whereIn('id', $accountIds)->where('status', 'available')->with('game')->get();
        
        // Rebuild clean cart session and calculate subtotal
        $cleanCart = [];
        $subtotal = 0;
        foreach ($accounts as $account) {
            $cleanCart[$account->id] = [
                'title' => $account->title,
                'price' => $account->price,
                'image' => $account->first_image,
                'game_name' => $account->game->name,
                'rank' => $account->rank
            ];
            $subtotal += $account->price;
        }
        session()->put('cart', $cleanCart);

        // Check if any applied coupon is valid
        $coupon = null;
        $discount = 0;
        if (session()->has('coupon_code')) {
            $code = session()->get('coupon_code');
            $couponModel = Coupon::where('code', $code)->first();
            if ($couponModel && $couponModel->isValidForAmount($subtotal)) {
                $coupon = $couponModel;
                $discount = $couponModel->calculateDiscount($subtotal);
            } else {
                session()->forget('coupon_code');
            }
        }

        $total = max(0, $subtotal - $discount);

        return view('cart.index', compact('accounts', 'subtotal', 'coupon', 'discount', 'total'));
    }

    /**
     * Add account to cart
     */
    public function add($id)
    {
        $account = Account::where('status', 'available')->findOrFail($id);
        
        $cart = session()->get('cart', []);
        
        // Since gaming accounts are unique, you can only add an account once.
        if (isset($cart[$id])) {
            return back()->with('info', 'Tài khoản này đã có sẵn trong giỏ hàng!');
        }

        $cart[$id] = [
            'title' => $account->title,
            'price' => $account->price,
            'image' => $account->first_image,
            'game_name' => $account->game->name,
            'rank' => $account->rank
        ];

        session()->put('cart', $cart);

        return redirect()->route('cart.index')->with('success', 'Đã thêm tài khoản vào giỏ hàng!');
    }

    /**
     * Buy Now (adds to cart and redirects to checkout instantly)
     */
    public function buyNow($id)
    {
        $account = Account::where('status', 'available')->findOrFail($id);
        
        $cart = session()->get('cart', []);
        $cart[$id] = [
            'title' => $account->title,
            'price' => $account->price,
            'image' => $account->first_image,
            'game_name' => $account->game->name,
            'rank' => $account->rank
        ];

        session()->put('cart', $cart);

        return redirect()->route('cart.index');
    }

    /**
     * Remove account from cart
     */
    public function remove($id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }

        return redirect()->route('cart.index')->with('success', 'Đã xóa tài khoản khỏi giỏ hàng!');
    }

    /**
     * Apply Coupon Code
     */
    public function applyCoupon(Request $request)
    {
        $request->validate([
            'code' => 'required|string',
        ]);

        $code = strtoupper($request->code);
        $coupon = Coupon::where('code', $code)->first();

        if (!$coupon) {
            return back()->with('error', 'Mã giảm giá không tồn tại.');
        }

        // Calculate current subtotal
        $cart = session()->get('cart', []);
        $subtotal = array_sum(array_column($cart, 'price'));

        if (!$coupon->isValidForAmount($subtotal)) {
            return back()->with('error', 'Mã giảm giá đã hết hạn hoặc không đủ điều kiện tối thiểu.');
        }

        session()->put('coupon_code', $coupon->code);

        return back()->with('success', 'Áp dụng mã giảm giá thành công!');
    }

    /**
     * Remove Coupon
     */
    public function removeCoupon()
    {
        session()->forget('coupon_code');
        return back()->with('success', 'Đã hủy áp dụng mã giảm giá.');
    }

    /**
     * Secure Checkout Processing
     */
    public function checkout(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Vui lòng đăng nhập để thanh toán.');
        }

        $user = Auth::user();
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('accounts.index')->with('error', 'Giỏ hàng của bạn đang trống.');
        }

        // 1. Double check database: verify that all items in cart are still 'available'
        $accountIds = array_keys($cart);
        $accounts = Account::whereIn('id', $accountIds)->where('status', 'available')->get();

        if (count($accounts) !== count($cart)) {
            // Some accounts were sold in the meantime. Rebuild cart.
            $cleanCart = [];
            foreach ($accounts as $account) {
                $cleanCart[$account->id] = [
                    'title' => $account->title,
                    'price' => $account->price,
                    'image' => $account->first_image,
                    'game_name' => $account->game->name,
                    'rank' => $account->rank
                ];
            }
            session()->put('cart', $cleanCart);
            return redirect()->route('cart.index')->with('error', 'Một số tài khoản trong giỏ hàng đã được bán hoặc không còn khả dụng.');
        }

        // 2. Calculations
        $subtotal = $accounts->sum('price');
        $discount = 0;
        $couponId = null;

        if (session()->has('coupon_code')) {
            $code = session()->get('coupon_code');
            $coupon = Coupon::where('code', $code)->first();
            if ($coupon && $coupon->isValidForAmount($subtotal)) {
                $couponId = $coupon->id;
                $discount = $coupon->calculateDiscount($subtotal);
            }
        }

        $finalAmount = max(0, $subtotal - $discount);

        // 3. Balance verification
        if ($user->balance < $finalAmount) {
            return redirect()->route('user.deposit')->with('error', 'Số dư tài khoản không đủ để thanh toán. Vui lòng nạp thêm tiền!');
        }

        // 4. Secure DB Transaction execution
        try {
            DB::transaction(function () use ($user, $accounts, $subtotal, $discount, $finalAmount, $couponId) {
                // Deduct balance from user
                // Using decrement to prevent race conditions
                DB::table('users')->where('id', $user->id)->decrement('balance', $finalAmount);

                // Create Order
                $order = Order::create([
                    'user_id' => $user->id,
                    'coupon_id' => $couponId,
                    'total_amount' => $subtotal,
                    'discount_amount' => $discount,
                    'final_amount' => $finalAmount,
                    'status' => 'completed'
                ]);

                // Create Order Items & Update Account Status
                foreach ($accounts as $account) {
                    OrderItem::create([
                        'order_id' => $order->id,
                        'account_id' => $account->id,
                        'price' => $account->price
                    ]);

                    // Update account status to sold
                    $account->update(['status' => 'sold']);
                }

                // Log Transaction
                Transaction::create([
                    'user_id' => $user->id,
                    'amount' => $finalAmount,
                    'type' => 'purchase',
                    'description' => "Thanh toán đơn hàng #{$order->id} mua " . count($accounts) . " tài khoản game.",
                    'status' => 'completed'
                ]);
            });

            // Clear Cart Session
            session()->forget('cart');
            session()->forget('coupon_code');

            return redirect()->route('user.purchased')->with('success', 'Thanh toán tài khoản game thành công! Bạn có thể xem thông tin đăng nhập tài khoản tại đây.');

        } catch (\Exception $e) {
            return redirect()->route('cart.index')->with('error', 'Đã xảy ra lỗi hệ thống trong quá trình thanh toán: ' . $e->getMessage());
        }
    }
}
