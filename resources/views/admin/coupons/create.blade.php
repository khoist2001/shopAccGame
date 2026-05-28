@extends('layouts.app')

@section('title', 'Tạo Mã Giảm Giá - GameShop Admin')

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <!-- Header title -->
    <div class="mb-8 border-b border-gaming-border/40 pb-5 flex items-center justify-between">
        <div class="text-left space-y-2">
            <h1 class="font-gaming font-black text-2xl tracking-wider text-white uppercase"><i class="fa-solid fa-ticket text-gaming-neon mr-2"></i>TẠO <span class="bg-gradient-to-r from-gaming-purple to-gaming-pink bg-clip-text text-transparent">MÃ GIẢM GIÁ</span></h1>
            <p class="text-xs text-gray-400">Đăng kí một mã coupon mới áp dụng khi người dùng thanh toán.</p>
        </div>
        <a href="{{ route('admin.coupons.index') }}" class="text-xs font-bold text-gray-400 hover:text-white transition-colors bg-gaming-card border border-gaming-border px-4 py-2.5 rounded-xl"><i class="fa-solid fa-arrow-left mr-2"></i>Quay lại</a>
    </div>

    <!-- Form Container -->
    <div class="bg-gaming-card border border-gaming-border p-8 rounded-2xl shadow-glass">
        <form action="{{ route('admin.coupons.store') }}" method="POST" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Coupon Code -->
                <div class="space-y-2">
                    <label for="code" class="block text-xs font-bold uppercase tracking-wider text-gray-400">Mã Coupon <span class="text-gaming-pink">*</span></label>
                    <input type="text" id="code" name="code" value="{{ old('code') }}" placeholder="Ví dụ: GAMING50, CHAOMUNG..." class="w-full bg-gaming-dark border border-gaming-border focus:border-gaming-purple rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:ring-1 focus:ring-gaming-purple font-mono uppercase @error('code') border-red-500 @enderror" required>
                    @error('code')
                        <p class="text-2xs text-red-400 font-semibold">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Min Spend -->
                <div class="space-y-2">
                    <label for="min_spend" class="block text-xs font-bold uppercase tracking-wider text-gray-400">Đơn Hàng Tối Thiểu (đ) <span class="text-gaming-pink">*</span></label>
                    <input type="number" id="min_spend" name="min_spend" value="{{ old('min_spend', 0) }}" placeholder="Ví dụ: 100000" class="w-full bg-gaming-dark border border-gaming-border focus:border-gaming-purple rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:ring-1 focus:ring-gaming-purple @error('min_spend') border-red-500 @enderror" required>
                    @error('min_spend')
                        <p class="text-2xs text-red-400 font-semibold">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Discount Amount -->
                <div class="space-y-2">
                    <label for="discount_amount" class="block text-xs font-bold uppercase tracking-wider text-gray-400">Giá Trị Giảm <span class="text-gaming-pink">*</span></label>
                    <input type="number" id="discount_amount" name="discount_amount" value="{{ old('discount_amount') }}" placeholder="Ví dụ: 20000 hoặc 10" class="w-full bg-gaming-dark border border-gaming-border focus:border-gaming-purple rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:ring-1 focus:ring-gaming-purple @error('discount_amount') border-red-500 @enderror" required>
                    @error('discount_amount')
                        <p class="text-2xs text-red-400 font-semibold">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Discount Type -->
                <div class="space-y-2">
                    <label for="discount_type" class="block text-xs font-bold uppercase tracking-wider text-gray-400">Loại Giảm Giá <span class="text-gaming-pink">*</span></label>
                    <select id="discount_type" name="discount_type" class="w-full bg-gaming-dark border border-gaming-border focus:border-gaming-purple rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:ring-1 focus:ring-gaming-purple @error('discount_type') border-red-500 @enderror" required>
                        <option value="fixed" {{ old('discount_type') === 'fixed' ? 'selected' : '' }}>Số tiền cố định (đ)</option>
                        <option value="percent" {{ old('discount_type') === 'percent' ? 'selected' : '' }}>Phần trăm (%)</option>
                    </select>
                    @error('discount_type')
                        <p class="text-2xs text-red-400 font-semibold">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Expires At -->
                <div class="space-y-2">
                    <label for="expires_at" class="block text-xs font-bold uppercase tracking-wider text-gray-400">Ngày Hết Hạn</label>
                    <input type="date" id="expires_at" name="expires_at" value="{{ old('expires_at') }}" class="w-full bg-gaming-dark border border-gaming-border focus:border-gaming-purple rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:ring-1 focus:ring-gaming-purple @error('expires_at') border-red-500 @enderror">
                    <p class="text-3xs text-gray-500 italic"><i class="fa-solid fa-circle-info mr-1"></i>Để trống nếu muốn mã giảm giá có hiệu lực vĩnh viễn.</p>
                    @error('expires_at')
                        <p class="text-2xs text-red-400 font-semibold">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Active -->
                <div class="space-y-2 flex flex-col justify-end pb-3">
                    <div class="flex items-center space-x-3 bg-gaming-dark/40 border border-gaming-border/60 p-3.5 rounded-xl">
                        <input type="checkbox" id="active" name="active" value="1" {{ old('active', true) ? 'checked' : '' }} class="h-5 w-5 rounded bg-gaming-dark border-gaming-border text-gaming-purple focus:ring-gaming-purple focus:ring-offset-0">
                        <div class="text-left">
                            <label for="active" class="block text-xs font-bold uppercase tracking-wider text-white cursor-pointer">Kích Hoạt Ngay</label>
                            <p class="text-3xs text-gray-400">Mã có thể bắt đầu sử dụng ngay lập tức.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="w-full bg-gradient-to-r from-gaming-purple to-gaming-pink py-4 rounded-xl text-sm font-bold tracking-widest text-white uppercase hover:opacity-90 shadow-neon-purple/20 transition-all transform hover:-translate-y-0.5"><i class="fa-solid fa-save mr-2"></i>TẠO MÃ GIẢM GIÁ</button>
        </form>
    </div>
</div>
@endsection
