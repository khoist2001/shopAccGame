@extends('layouts.app')

@section('title', 'Thông Tin Tài Khoản - GameShop')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
        
        <!-- Sidebar Navigation Dashboard Menu (col-span-3) -->
        <div class="lg:col-span-3 bg-gaming-card border border-gaming-border p-6 rounded-2xl space-y-6 shadow-glass">
            <div class="flex flex-col items-center text-center space-y-3 pb-6 border-b border-gaming-border">
                <img class="h-20 w-20 rounded-full border-4 border-gaming-purple object-cover" src="{{ Auth::user()->avatar ?? 'https://api.dicebear.com/7.x/bottts/svg?seed=' . Auth::user()->email }}" alt="Avatar">
                <div>
                    <h2 class="font-display font-bold text-white text-base">{{ Auth::user()->name }}</h2>
                    <span class="text-3xs text-gaming-neon font-bold font-gaming tracking-widest uppercase">{{ Auth::user()->role }}</span>
                </div>
            </div>
            
            <nav class="flex flex-col gap-2 text-sm text-gray-400 font-semibold">
                <a href="{{ route('user.profile') }}" class="flex items-center px-4 py-2.5 rounded-xl hover:text-white transition-all bg-gaming-purple text-white"><i class="fa-solid fa-user mr-3 text-base"></i>Thông tin cá nhân</a>
                <a href="{{ route('user.deposit') }}" class="flex items-center px-4 py-2.5 rounded-xl hover:text-white hover:bg-gaming-dark transition-all"><i class="fa-solid fa-wallet mr-3 text-base text-gaming-neon"></i>Nạp tiền vào ví</a>
                <a href="{{ route('user.transactions') }}" class="flex items-center px-4 py-2.5 rounded-xl hover:text-white hover:bg-gaming-dark transition-all"><i class="fa-solid fa-history mr-3 text-base"></i>Lịch sử ví ảo</a>
                <a href="{{ route('user.purchased') }}" class="flex items-center px-4 py-2.5 rounded-xl hover:text-white hover:bg-gaming-dark transition-all"><i class="fa-solid fa-key mr-3 text-base"></i>Kho Acc Đã Mua</a>
                <a href="{{ route('user.wishlist') }}" class="flex items-center px-4 py-2.5 rounded-xl hover:text-white hover:bg-gaming-dark transition-all"><i class="fa-solid fa-heart mr-3 text-base text-gaming-pink"></i>Acc đã lưu</a>
            </nav>
        </div>

        <!-- Profile Edit Card (col-span-9) -->
        <div class="lg:col-span-9 bg-gaming-card border border-gaming-border p-6 sm:p-8 rounded-2xl shadow-glass space-y-6">
            <h2 class="font-display font-bold text-xl text-white border-b border-gaming-border pb-4 flex items-center">
                <i class="fa-solid fa-user-gear text-gaming-purple mr-3"></i>Cấu Hình Tài Khoản
            </h2>

            <form action="{{ route('user.profile.update') }}" method="POST" class="space-y-6">
                @csrf
                
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <!-- Name Input -->
                    <div>
                        <label for="name" class="block text-xs font-semibold uppercase tracking-wider text-gray-400 mb-1.5">Họ và Tên</label>
                        <input id="name" name="name" type="text" required value="{{ old('name', Auth::user()->name) }}"
                            class="bg-gaming-dark/60 block w-full px-3 py-3 border border-gaming-border rounded-xl text-gray-200 text-sm focus:outline-none focus:border-gaming-purple">
                    </div>

                    <!-- Email Input -->
                    <div>
                        <label for="email" class="block text-xs font-semibold uppercase tracking-wider text-gray-400 mb-1.5">Địa chỉ Email</label>
                        <input id="email" name="email" type="email" required value="{{ old('email', Auth::user()->email) }}"
                            class="bg-gaming-dark/60 block w-full px-3 py-3 border border-gaming-border rounded-xl text-gray-200 text-sm focus:outline-none focus:border-gaming-purple">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 pt-4 border-t border-gaming-border/50">
                    <!-- Password Input -->
                    <div>
                        <label for="password" class="block text-xs font-semibold uppercase tracking-wider text-gray-400 mb-1.5">Mật khẩu mới (Để trống nếu giữ nguyên)</label>
                        <input id="password" name="password" type="password"
                            class="bg-gaming-dark/60 block w-full px-3 py-3 border border-gaming-border rounded-xl text-gray-200 text-sm focus:outline-none focus:border-gaming-purple"
                            placeholder="Nhập mật khẩu mới">
                    </div>

                    <!-- Confirm Password Input -->
                    <div>
                        <label for="password_confirmation" class="block text-xs font-semibold uppercase tracking-wider text-gray-400 mb-1.5">Xác nhận mật khẩu mới</label>
                        <input id="password_confirmation" name="password_confirmation" type="password"
                            class="bg-gaming-dark/60 block w-full px-3 py-3 border border-gaming-border rounded-xl text-gray-200 text-sm focus:outline-none focus:border-gaming-purple"
                            placeholder="Nhập lại mật khẩu mới">
                    </div>
                </div>

                <!-- Submit -->
                <div class="flex justify-end pt-4 border-t border-gaming-border/50">
                    <button type="submit"
                        class="bg-gradient-to-r from-gaming-purple to-gaming-pink text-sm font-bold px-6 py-3 rounded-xl text-white shadow-neon-purple/20 hover:opacity-90 transition-all transform hover:-translate-y-0.5">
                        <i class="fa-solid fa-save mr-2"></i>LƯU THAY ĐỔI
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
