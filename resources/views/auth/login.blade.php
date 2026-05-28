@extends('layouts.app')

@section('title', 'Đăng Nhập - GameShop')

@section('content')
<div class="min-h-[70vh] flex flex-col items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8 bg-gaming-card border border-gaming-border p-8 rounded-2xl shadow-glass relative overflow-hidden group">
        <!-- Neon Glow Background Accent -->
        <div class="absolute -top-12 -left-12 w-24 h-24 rounded-full bg-gaming-purple/20 blur-xl group-hover:bg-gaming-purple/30 transition-all duration-500"></div>
        <div class="absolute -bottom-12 -right-12 w-24 h-24 rounded-full bg-gaming-neon/20 blur-xl group-hover:bg-gaming-neon/30 transition-all duration-500"></div>

        <div class="text-center relative">
            <h2 class="font-gaming font-bold text-3xl tracking-wide bg-gradient-to-r from-gaming-purple to-gaming-neon bg-clip-text text-transparent uppercase">Đăng Nhập</h2>
            <p class="mt-2 text-sm text-gray-400">Chào mừng chiến binh! Nhập thông tin để bắt đầu mua sắm.</p>
        </div>

        <form class="mt-8 space-y-6" action="{{ route('login') }}" method="POST">
            @csrf
            
            <div class="space-y-4">
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
                    <div class="flex items-center justify-between mb-1.5">
                        <label for="password" class="block text-xs font-semibold uppercase tracking-wider text-gray-400">Mật khẩu</label>
                        <a href="{{ route('forgot-password') }}" class="text-xs font-medium text-gaming-purple hover:text-gaming-neon transition-colors">Quên mật khẩu?</a>
                    </div>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-gray-500"><i class="fa-solid fa-lock"></i></span>
                        <input id="password" name="password" type="password" autocomplete="current-password" required
                            class="bg-gaming-dark/60 block w-full pl-10 pr-3 py-3 border border-gaming-border rounded-xl text-gray-200 placeholder-gray-500 text-sm focus:outline-none focus:border-gaming-purple focus:ring-1 focus:ring-gaming-purple transition-all shadow-inner focus:shadow-neon-purple/10" 
                            placeholder="••••••••">
                    </div>
                </div>
            </div>

            <!-- Remember me checkbox -->
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <input id="remember" name="remember" type="checkbox"
                        class="h-4 w-4 bg-gaming-dark border-gaming-border text-gaming-purple focus:ring-gaming-purple rounded">
                    <label for="remember" class="ml-2 block text-sm text-gray-400 select-none cursor-pointer">Ghi nhớ đăng nhập</label>
                </div>
            </div>

            <!-- Submit button -->
            <div>
                <button type="submit" 
                    class="group relative w-full flex justify-center py-3.5 px-4 border border-transparent text-sm font-bold rounded-xl text-white bg-gradient-to-r from-gaming-purple to-gaming-pink hover:opacity-90 focus:outline-none transition-all shadow-neon-purple/20 hover:shadow-neon-purple/40 transform hover:-translate-y-0.5">
                    <span class="absolute left-0 inset-y-0 flex items-center pl-3 text-white/50"><i class="fa-solid fa-arrow-right-to-bracket group-hover:text-white transition-colors"></i></span>
                    ĐĂNG NHẬP NGAY
                </button>
            </div>
        </form>

        <div class="mt-6 text-center border-t border-gaming-border/50 pt-6">
            <span class="text-sm text-gray-400">Bạn chưa có tài khoản?</span>
            <a href="{{ route('register') }}" class="text-sm font-bold text-gaming-neon hover:text-white transition-colors ml-1.5">Đăng ký thành viên</a>
        </div>
    </div>
</div>
@endsection
