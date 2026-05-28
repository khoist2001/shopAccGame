<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Transaction;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * View Profile Page
     */
    public function profile()
    {
        return view('user.profile');
    }

    /**
     * Update Profile Info
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:6|confirmed',
        ], [
            'name.required' => 'Họ và tên không được để trống.',
            'email.required' => 'Email không được để trống.',
            'email.unique' => 'Email này đã được sử dụng.',
            'password.min' => 'Mật khẩu mới phải từ 6 ký tự.',
            'password.confirmed' => 'Xác nhận mật khẩu không khớp.',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return back()->with('success', 'Cập nhật thông tin tài khoản thành công!');
    }

    /**
     * View Wallet Deposit Page
     */
    public function deposit()
    {
        $transactions = Transaction::where('user_id', Auth::id())
            ->where('type', 'deposit')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('user.deposit', compact('transactions'));
    }

    /**
     * Process Virtual Deposit (Simulated ATM/VietQR instant payment check)
     */
    public function processDeposit(Request $request)
    {
        $request->validate([
            'amount' => 'required|integer|min:20000',
        ], [
            'amount.required' => 'Vui lòng chọn hoặc nhập số tiền.',
            'amount.integer' => 'Số tiền phải là số nguyên.',
            'amount.min' => 'Số tiền nạp tối thiểu là 20.000đ.',
        ]);

        $user = Auth::user();
        $amount = $request->amount;

        // DB decrement and increment safely
        // Using increment to prevent race conditions
        $user->increment('balance', $amount);

        // Record successful virtual transaction
        Transaction::create([
            'user_id' => $user->id,
            'amount' => $amount,
            'type' => 'deposit',
            'description' => 'Nạp tiền vào tài khoản (Mô phỏng VietQR/ATM thành công)',
            'status' => 'completed'
        ]);

        return redirect()->route('user.transactions')->with('success', 'Mô phỏng nạp tiền thành công! Đã cộng ' . number_format($amount, 0, ',', '.') . 'đ vào số dư tài khoản của bạn.');
    }

    /**
     * View Transaction Logs Page
     */
    public function transactions()
    {
        $transactions = Transaction::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('user.transactions', compact('transactions'));
    }

    /**
     * View Purchased Accounts Cabinet (Shows Login Credentials)
     */
    public function purchased()
    {
        $orders = Order::where('user_id', Auth::id())
            ->with(['accounts' => function($q) {
                $q->with('game');
            }])
            ->orderBy('created_at', 'desc')
            ->paginate(5);

        return view('user.purchased', compact('orders'));
    }
}
