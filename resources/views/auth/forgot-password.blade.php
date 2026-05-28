@extends('layouts.app')

@section('title', 'Quên Mật Khẩu - GameShop')

@section('content')
<div class="min-h-[70vh] flex flex-col items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8 bg-gaming-card border border-gaming-border p-8 rounded-2xl shadow-glass relative overflow-hidden group">
        <!-- Neon Glow Accent -->
        <div class="absolute -top-12 -left-12 w-24 h-24 rounded-full bg-gaming-purple/20 blur-xl group-hover:bg-gaming-purple/30 transition-all duration-500"></div>
        <div class="absolute -bottom-12 -right-12 w-24 h-24 rounded-full bg-gaming-neon/20 blur-xl group-hover:bg-gaming-neon/30 transition-all duration-500"></div>

        <div class="text-center relative">
            <h2 class="font-gaming font-bold text-3xl tracking-wide bg-gradient-to-r from-gaming-purple to-gaming-neon bg-clip-text text-transparent uppercase">Khôi Phục Mật Khẩu</h2>
            <p class="mt-2 text-sm text-gray-400">Nhập email đã đăng ký. Hệ thống sẽ gửi hướng dẫn khôi phục mật khẩu cho bạn.</p>
        </div>

        <form class="mt-8 space-y-6" action="{{ route('forgot-password') }}" method="POST">
            @csrf
            
            <div class="space-y-4">
                <!-- Email input -->
                <div>
                    <label for="email" class="block text-xs font-semibold uppercase tracking-wider text-gray-400 mb-1.5">Địa chỉ Email</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-gray-500"><i class="fa-solid fa-envelope"></i></span>
                        <input id="email" name="email" type="email" autocomplete="email" required
                            class="bg-gaming-dark/60 block w-full pl-10 pr-3 py-3 border border-gaming-border rounded-xl text-gray-200 placeholder-gray-500 text-sm focus:outline-none focus:border-gaming-purple focus:ring-1 focus:ring-gaming-purple transition-all shadow-inner focus:shadow-neon-purple/10" 
                            placeholder="quan@example.com">
                    </div>
                </div>
            </div>

            <!-- Submit button -->
            <div>
                <button type="submit" 
                    class="group relative w-full flex justify-center py-3.5 px-4 border border-transparent text-sm font-bold rounded-xl text-white bg-gradient-to-r from-gaming-purple to-gaming-pink hover:opacity-90 focus:outline-none transition-all shadow-neon-purple/20 hover:shadow-neon-purple/40 transform hover:-translate-y-0.5">
                    <span class="absolute left-0 inset-y-0 flex items-center pl-3 text-white/50"><i class="fa-solid fa-paper-plane group-hover:text-white transition-colors"></i></span>
                    GỬI YÊU CẦU
                </button>
            </div>
        </form>

        <div class="mt-6 text-center border-t border-gaming-border/50 pt-6 flex justify-between text-sm">
            <a href="{{ route('login') }}" class="font-semibold text-gaming-purple hover:text-gaming-neon transition-colors"><i class="fa-solid fa-arrow-left mr-1.5"></i>Quay lại đăng nhập</a>
            <a href="{{ route('register') }}" class="font-semibold text-gaming-neon hover:text-white transition-colors">Đăng ký mới</a>
        </div>
    </div>
</div>
@endsection
