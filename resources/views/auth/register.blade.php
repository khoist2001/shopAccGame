@extends('layouts.app')

@section('title', 'Đăng Ký Thành Viên - GameShop')

@section('content')
<div class="min-h-[85vh] flex flex-col items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8 bg-gaming-card border border-gaming-border p-8 rounded-2xl shadow-glass relative overflow-hidden group">
        <!-- Neon Glow Accent -->
        <div class="absolute -top-12 -left-12 w-24 h-24 rounded-full bg-gaming-purple/20 blur-xl group-hover:bg-gaming-purple/30 transition-all duration-500"></div>
        <div class="absolute -bottom-12 -right-12 w-24 h-24 rounded-full bg-gaming-neon/20 blur-xl group-hover:bg-gaming-neon/30 transition-all duration-500"></div>

        <div class="text-center relative">
            <h2 class="font-gaming font-bold text-3xl tracking-wide bg-gradient-to-r from-gaming-purple to-gaming-neon bg-clip-text text-transparent uppercase">Đăng Ký</h2>
            <p class="mt-2 text-sm text-gray-400">Gia nhập cộng đồng game thủ chuyên nghiệp của GameShop.</p>
        </div>

        <form class="mt-8 space-y-5" action="{{ route('register') }}" method="POST">
            @csrf
            
            <div class="space-y-4">
                <!-- Name input -->
                <div>
                    <label for="name" class="block text-xs font-semibold uppercase tracking-wider text-gray-400 mb-1.5">Họ và Tên</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-gray-500"><i class="fa-solid fa-user"></i></span>
                        <input id="name" name="name" type="text" required value="{{ old('name') }}"
                            class="bg-gaming-dark/60 block w-full pl-10 pr-3 py-3 border border-gaming-border rounded-xl text-gray-200 placeholder-gray-500 text-sm focus:outline-none focus:border-gaming-purple focus:ring-1 focus:ring-gaming-purple transition-all shadow-inner focus:shadow-neon-purple/10" 
                            placeholder="Nguyễn Văn A">
                    </div>
                </div>

                <!-- Email input -->
                <div>
                    <label for="email" class="block text-xs font-semibold uppercase tracking-wider text-gray-400 mb-1.5">Địa chỉ Email</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-gray-500"><i class="fa-solid fa-envelope"></i></span>
                        <input id="email" name="email" type="email" autocomplete="email" required value="{{ old('email') }}"
                            class="bg-gaming-dark/60 block w-full pl-10 pr-3 py-3 border border-gaming-border rounded-xl text-gray-200 placeholder-gray-500 text-sm focus:outline-none focus:border-gaming-purple focus:ring-1 focus:ring-gaming-purple transition-all shadow-inner focus:shadow-neon-purple/10" 
                            placeholder="quan@example.com">
                    </div>
                </div>

                <!-- Password input -->
                <div>
                    <label for="password" class="block text-xs font-semibold uppercase tracking-wider text-gray-400 mb-1.5">Mật khẩu</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-gray-500"><i class="fa-solid fa-lock"></i></span>
                        <input id="password" name="password" type="password" required
                            class="bg-gaming-dark/60 block w-full pl-10 pr-3 py-3 border border-gaming-border rounded-xl text-gray-200 placeholder-gray-500 text-sm focus:outline-none focus:border-gaming-purple focus:ring-1 focus:ring-gaming-purple transition-all shadow-inner focus:shadow-neon-purple/10" 
                            placeholder="Tối thiểu 6 ký tự">
                    </div>
                </div>

                <!-- Confirm Password input -->
                <div>
                    <label for="password_confirmation" class="block text-xs font-semibold uppercase tracking-wider text-gray-400 mb-1.5">Xác nhận mật khẩu</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-gray-500"><i class="fa-solid fa-circle-check"></i></span>
                        <input id="password_confirmation" name="password_confirmation" type="password" required
                            class="bg-gaming-dark/60 block w-full pl-10 pr-3 py-3 border border-gaming-border rounded-xl text-gray-200 placeholder-gray-500 text-sm focus:outline-none focus:border-gaming-purple focus:ring-1 focus:ring-gaming-purple transition-all shadow-inner focus:shadow-neon-purple/10" 
                            placeholder="Nhập lại mật khẩu">
                    </div>
                </div>
            </div>

            <!-- Policy Agreement checkbox -->
            <div class="flex items-center">
                <input id="terms" name="terms" type="checkbox" required checked
                    class="h-4 w-4 bg-gaming-dark border-gaming-border text-gaming-purple focus:ring-gaming-purple rounded">
                <label for="terms" class="ml-2 block text-xs text-gray-400 select-none cursor-pointer">Tôi đồng ý với tất cả điều khoản sử dụng của shop</label>
            </div>

            <!-- Submit button -->
            <div>
                <button type="submit" 
                    class="group relative w-full flex justify-center py-3.5 px-4 border border-transparent text-sm font-bold rounded-xl text-white bg-gradient-to-r from-gaming-purple to-gaming-pink hover:opacity-90 focus:outline-none transition-all shadow-neon-purple/20 hover:shadow-neon-purple/40 transform hover:-translate-y-0.5">
                    <span class="absolute left-0 inset-y-0 flex items-center pl-3 text-white/50"><i class="fa-solid fa-user-plus group-hover:text-white transition-colors"></i></span>
                    ĐĂNG KÝ NGAY
                </button>
            </div>
        </form>

        <div class="mt-6 text-center border-t border-gaming-border/50 pt-6">
            <span class="text-sm text-gray-400">Bạn đã có tài khoản?</span>
            <a href="{{ route('login') }}" class="text-sm font-bold text-gaming-neon hover:text-white transition-colors ml-1.5">Đăng nhập ngay</a>
        </div>
    </div>
</div>
@endsection
