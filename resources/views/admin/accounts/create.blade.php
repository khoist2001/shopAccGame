@extends('layouts.app')

@section('title', 'Đăng Bán Account Game - GameShop Admin')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <!-- Header title -->
    <div class="mb-8 border-b border-gaming-border/40 pb-5 flex items-center justify-between">
        <div class="text-left space-y-2">
            <h1 class="font-gaming font-black text-2xl tracking-wider text-white uppercase"><i class="fa-solid fa-plus-circle text-gaming-neon mr-2"></i>ĐĂNG BÁN <span class="bg-gradient-to-r from-gaming-purple to-gaming-pink bg-clip-text text-transparent">ACCOUNT MỚI</span></h1>
            <p class="text-xs text-gray-400">Tạo tài khoản game mới đăng bán tự động trên hệ thống.</p>
        </div>
        <a href="{{ route('admin.accounts.index') }}" class="text-xs font-bold text-gray-400 hover:text-white transition-colors bg-gaming-card border border-gaming-border px-4 py-2.5 rounded-xl"><i class="fa-solid fa-arrow-left mr-2"></i>Quay lại</a>
    </div>

    <!-- Form Container -->
    <div class="bg-gaming-card border border-gaming-border p-8 rounded-2xl shadow-glass">
        <form action="{{ route('admin.accounts.store') }}" method="POST" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Game category select -->
                <div class="space-y-2">
                    <label for="game_id" class="block text-xs font-bold uppercase tracking-wider text-gray-400">Tựa Game <span class="text-gaming-pink">*</span></label>
                    <select id="game_id" name="game_id" class="w-full bg-gaming-dark border border-gaming-border focus:border-gaming-purple rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:ring-1 focus:ring-gaming-purple @error('game_id') border-red-500 @enderror" required>
                        <option value="">-- Chọn game --option>
                        @foreach($games as $game)
                            <option value="{{ $game->id }}" {{ old('game_id') == $game->id ? 'selected' : '' }}>{{ $game->name }}</option>
                        @endforeach
                    </select>
                    @error('game_id')
                        <p class="text-2xs text-red-400 font-semibold">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Account Title -->
                <div class="space-y-2">
                    <label for="title" class="block text-xs font-bold uppercase tracking-wider text-gray-400">Tiêu đề Account <span class="text-gaming-pink">*</span></label>
                    <input type="text" id="title" name="title" value="{{ old('title') }}" placeholder="Ví dụ: Acc LOL Siêu VIP 99 Skin, Full Tướng..." class="w-full bg-gaming-dark border border-gaming-border focus:border-gaming-purple rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:ring-1 focus:ring-gaming-purple @error('title') border-red-500 @enderror" required>
                    @error('title')
                        <p class="text-2xs text-red-400 font-semibold">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Price -->
                <div class="space-y-2">
                    <label for="price" class="block text-xs font-bold uppercase tracking-wider text-gray-400">Giá Bán (đ) <span class="text-gaming-pink">*</span></label>
                    <input type="number" id="price" name="price" value="{{ old('price') }}" placeholder="Ví dụ: 150000" class="w-full bg-gaming-dark border border-gaming-border focus:border-gaming-purple rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:ring-1 focus:ring-gaming-purple @error('price') border-red-500 @enderror" required>
                    @error('price')
                        <p class="text-2xs text-red-400 font-semibold">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Rank -->
                <div class="space-y-2">
                    <label for="rank" class="block text-xs font-bold uppercase tracking-wider text-gray-400">Rank / Cấp Bậc</label>
                    <input type="text" id="rank" name="rank" value="{{ old('rank') }}" placeholder="Ví dụ: Cao Thủ, Kim Cương I, Vàng..." class="w-full bg-gaming-dark border border-gaming-border focus:border-gaming-purple rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:ring-1 focus:ring-gaming-purple @error('rank') border-red-500 @enderror">
                    @error('rank')
                        <p class="text-2xs text-red-400 font-semibold">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Login Details (Credentials) -->
            <div class="space-y-2">
                <label for="login_details" class="block text-xs font-bold uppercase tracking-wider text-gray-400">Thông tin đăng nhập tài khoản <span class="text-gaming-pink">*</span></label>
                <textarea id="login_details" name="login_details" rows="3" placeholder="Ví dụ: tài_khoản | mật_khẩu (Thông tin này sẽ được ẩn và hiển thị ngay sau khi người dùng mua thành công)" class="w-full bg-gaming-dark border border-gaming-border focus:border-gaming-purple rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:ring-1 focus:ring-gaming-purple @error('login_details') border-red-500 @enderror" required>{{ old('login_details') }}</textarea>
                <p class="text-3xs text-gray-500 italic"><i class="fa-solid fa-circle-info mr-1"></i>Hệ thống tự động hóa ẩn thông tin đăng nhập, bảo mật 100%.</p>
                @error('login_details')
                    <p class="text-2xs text-red-400 font-semibold">{{ $message }}</p>
                @enderror
            </div>

            <!-- Raw Images list -->
            <div class="space-y-2">
                <label for="images_raw" class="block text-xs font-bold uppercase tracking-wider text-gray-400">Danh sách link ảnh minh họa <span class="text-gaming-pink">*</span></label>
                <textarea id="images_raw" name="images_raw" rows="4" placeholder="Nhập mỗi dòng một URL hình ảnh minh họa..." class="w-full bg-gaming-dark border border-gaming-border focus:border-gaming-purple rounded-xl px-4 py-3 text-sm text-white font-mono focus:outline-none focus:ring-1 focus:ring-gaming-purple @error('images_raw') border-red-500 @enderror" required>{{ old('images_raw') }}</textarea>
                <p class="text-3xs text-gray-500 italic"><i class="fa-solid fa-circle-info mr-1"></i>Vui lòng dùng link ảnh thực tế. Bạn có thể sử dụng các URL ảnh gaming từ Unsplash hoặc lưu trữ trực tuyến.</p>
                @error('images_raw')
                    <p class="text-2xs text-red-400 font-semibold">{{ $message }}</p>
                @enderror
            </div>

            <!-- Description -->
            <div class="space-y-2">
                <label for="description" class="block text-xs font-bold uppercase tracking-wider text-gray-400">Mô tả chi tiết Account</label>
                <textarea id="description" name="description" rows="5" placeholder="Nhập các đặc điểm nổi bật như skin súng hiếm, ngọc bổ trợ, tướng tủ..." class="w-full bg-gaming-dark border border-gaming-border focus:border-gaming-purple rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:ring-1 focus:ring-gaming-purple @error('description') border-red-500 @enderror">{{ old('description') }}</textarea>
                @error('description')
                    <p class="text-2xs text-red-400 font-semibold">{{ $message }}</p>
                @enderror
            </div>

            <!-- Checkbox Featured -->
            <div class="flex items-center space-x-3 bg-gaming-dark/40 border border-gaming-border/60 p-4 rounded-xl">
                <input type="checkbox" id="is_featured" name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }} class="h-5 w-5 rounded bg-gaming-dark border-gaming-border text-gaming-purple focus:ring-gaming-purple focus:ring-offset-0">
                <div class="text-left">
                    <label for="is_featured" class="block text-xs font-bold uppercase tracking-wider text-white cursor-pointer">Đặt làm Account Nổi Bật</label>
                    <p class="text-3xs text-gray-400">Hiển thị account này trên mục tiêu điểm nổi bật tại trang chủ để tăng lượt xem.</p>
                </div>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="w-full bg-gradient-to-r from-gaming-purple to-gaming-pink py-4 rounded-xl text-sm font-bold tracking-widest text-white uppercase hover:opacity-90 shadow-neon-purple/20 transition-all transform hover:-translate-y-0.5"><i class="fa-solid fa-upload mr-2"></i>ĐĂNG BÁN TÀI KHOẢN</button>
        </form>
    </div>
</div>
@endsection
