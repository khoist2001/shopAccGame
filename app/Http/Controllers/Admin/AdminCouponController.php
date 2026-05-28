<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Coupon;

class AdminCouponController extends Controller
{
    public function index()
    {
        $coupons = Coupon::paginate(10);
        return view('admin.coupons.index', compact('coupons'));
    }

    public function create()
    {
        return view('admin.coupons.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|string|unique:coupons|max:50',
            'discount_amount' => 'required|numeric|min:0',
            'discount_type' => 'required|string|in:fixed,percent',
            'min_spend' => 'required|numeric|min:0',
            'expires_at' => 'nullable|date',
            'active' => 'nullable|boolean',
        ]);

        Coupon::create([
            'code' => strtoupper($request->code),
            'discount_amount' => $request->discount_amount,
            'discount_type' => $request->discount_type,
            'min_spend' => $request->min_spend,
            'expires_at' => $request->expires_at,
            'active' => $request->has('active'),
        ]);

        return redirect()->route('admin.coupons.index')->with('success', 'Tạo mã giảm giá thành công!');
    }

    public function edit($id)
    {
        $coupon = Coupon::findOrFail($id);
        return view('admin.coupons.edit', compact('coupon'));
    }

    public function update(Request $request, $id)
    {
        $coupon = Coupon::findOrFail($id);

        $request->validate([
            'code' => 'required|string|max:50|unique:coupons,code,' . $coupon->id,
            'discount_amount' => 'required|numeric|min:0',
            'discount_type' => 'required|string|in:fixed,percent',
            'min_spend' => 'required|numeric|min:0',
            'expires_at' => 'nullable|date',
            'active' => 'nullable|boolean',
        ]);

        $coupon->update([
            'code' => strtoupper($request->code),
            'discount_amount' => $request->discount_amount,
            'discount_type' => $request->discount_type,
            'min_spend' => $request->min_spend,
            'expires_at' => $request->expires_at,
            'active' => $request->has('active'),
        ]);

        return redirect()->route('admin.coupons.index')->with('success', 'Cập nhật mã giảm giá thành công!');
    }

    public function destroy($id)
    {
        $coupon = Coupon::findOrFail($id);
        $coupon->delete();

        return redirect()->route('admin.coupons.index')->with('success', 'Xóa mã giảm giá thành công!');
    }
}
