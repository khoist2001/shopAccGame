@extends('layouts.app')

@section('title', 'Tài Khoản Đã Mua - GameShop')

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
                <a href="{{ route('user.profile') }}" class="flex items-center px-4 py-2.5 rounded-xl hover:text-white hover:bg-gaming-dark transition-all"><i class="fa-solid fa-user mr-3 text-base"></i>Thông tin cá nhân</a>
                <a href="{{ route('user.deposit') }}" class="flex items-center px-4 py-2.5 rounded-xl hover:text-white hover:bg-gaming-dark transition-all"><i class="fa-solid fa-wallet mr-3 text-base text-gaming-neon"></i>Nạp tiền vào ví</a>
                <a href="{{ route('user.transactions') }}" class="flex items-center px-4 py-2.5 rounded-xl hover:text-white hover:bg-gaming-dark transition-all"><i class="fa-solid fa-history mr-3 text-base"></i>Lịch sử ví ảo</a>
                <a href="{{ route('user.purchased') }}" class="flex items-center px-4 py-2.5 rounded-xl hover:text-white transition-all bg-gaming-purple text-white"><i class="fa-solid fa-key mr-3 text-base"></i>Kho Acc Đã Mua</a>
                <a href="{{ route('user.wishlist') }}" class="flex items-center px-4 py-2.5 rounded-xl hover:text-white hover:bg-gaming-dark transition-all"><i class="fa-solid fa-heart mr-3 text-base text-gaming-pink"></i>Acc đã lưu</a>
            </nav>
        </div>

        <!-- Purchased List Area (col-span-9) -->
        <div class="lg:col-span-9 space-y-6">
            <h2 class="font-display font-bold text-xl text-white border-b border-gaming-border pb-4 flex items-center justify-between">
                <span>Kho Tài Khoản Đã Sở Hữu</span>
                <span class="text-xs bg-gaming-dark border border-gaming-border text-gaming-purple py-1 px-3 rounded-full font-gaming">Số lượng đơn: {{ $orders->total() }}</span>
            </h2>

            @forelse($orders as $order)
                <div class="bg-gaming-card border border-gaming-border p-6 rounded-2xl shadow-glass space-y-6 relative overflow-hidden group">
                    <!-- Order identification bar -->
                    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between border-b border-gaming-border/50 pb-4 gap-2">
                        <div>
                            <span class="text-xs text-gray-400 font-semibold">Đơn hàng: <strong class="text-white font-gaming">#{{ $order->id }}</strong></span>
                            <span class="text-xs text-gray-500 ml-3">• Ngày mua: {{ $order->created_at->format('d/m/Y H:i') }}</span>
                        </div>
                        <div class="text-right">
                            <span class="text-xs text-gray-500 uppercase tracking-widest font-semibold block sm:inline">Tổng thanh toán:</span>
                            <span class="text-sm font-black text-gaming-neon font-gaming ml-1">{{ number_format($order->final_amount, 0, ',', '.') }}đ</span>
                        </div>
                    </div>

                    <!-- Items bought in this order -->
                    <div class="space-y-4">
                        @foreach($order->accounts as $account)
                            <div class="bg-gaming-dark/40 border border-gaming-border/60 p-4 rounded-xl flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 relative">
                                <div class="flex items-center space-x-4">
                                    <div class="h-12 w-20 rounded-lg overflow-hidden bg-gaming-dark flex-shrink-0 border border-gaming-border/60">
                                        <img src="{{ $account->first_image }}" class="w-full h-full object-cover">
                                    </div>
                                    <div>
                                        <span class="text-4xs bg-gaming-neon/20 text-gaming-neon border border-gaming-neon/30 px-2 py-0.5 rounded uppercase font-gaming font-bold">
                                            {{ $account->game->name }}
                                        </span>
                                        <h3 class="font-display font-semibold text-white text-sm mt-1 line-clamp-1">
                                            <a href="{{ route('accounts.show', $account->id) }}" class="hover:text-gaming-neon transition-colors">{{ $account->title }}</a>
                                        </h3>
                                        <p class="text-xs text-gray-500 mt-0.5">Rank: {{ $account->rank ?? 'N/A' }} • Mã số: #{{ $account->id }}</p>
                                    </div>
                                </div>

                                <!-- Login details and quick copy -->
                                <div class="w-full sm:w-auto bg-gaming-card/80 border border-gaming-border p-3 rounded-xl space-y-2 flex-shrink-0 text-left"
                                    x-data="{ 
                                        details: '{{ $account->login_details ?? 'Chưa cấu hình thông tin đăng nhập' }}',
                                        copyToClipboard(text, msg) {
                                            navigator.clipboard.writeText(text);
                                            triggerToast(msg, 'success');
                                        }
                                    }">
                                    
                                    <span class="block text-4xs text-gaming-purple uppercase tracking-widest font-black"><i class="fa-solid fa-shield-halved mr-1 text-xs"></i>Thông tin tài khoản mật khẩu</span>
                                    
                                    <div class="flex flex-col gap-1.5 pt-1">
                                        @php
                                            // Assume details format: "Username: admin_lol | Password: mypassword"
                                            // Or split by space/bars
                                            $parts = explode('|', $account->login_details);
                                            $userVal = isset($parts[0]) ? trim(str_replace('Username:', '', $parts[0])) : 'N/A';
                                            $passVal = isset($parts[1]) ? trim(str_replace('Password:', '', $parts[1])) : 'N/A';
                                        @endphp
                                        
                                        <div class="flex items-center justify-between text-xs gap-3">
                                            <span class="text-gray-400">Tài khoản: <strong class="text-white font-mono select-all">{{ $userVal }}</strong></span>
                                            <button type="button" @click="copyToClipboard('{{ $userVal }}', 'Đã copy tài khoản!')" 
                                                class="text-gaming-neon hover:text-white transition-colors"><i class="fa-regular fa-copy text-sm"></i></button>
                                        </div>
                                        
                                        <div class="flex items-center justify-between text-xs gap-3">
                                            <span class="text-gray-400">Mật khẩu: <strong class="text-white font-mono select-all">{{ $passVal }}</strong></span>
                                            <button type="button" @click="copyToClipboard('{{ $passVal }}', 'Đã copy mật khẩu!')" 
                                                class="text-gaming-neon hover:text-white transition-colors"><i class="fa-regular fa-copy text-sm"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @empty
                <div class="py-20 text-center text-gray-400 flex flex-col items-center justify-center space-y-3 bg-gaming-card border border-gaming-border rounded-2xl shadow-glass">
                    <i class="fa-solid fa-key text-5xl text-gray-600"></i>
                    <h3 class="font-semibold text-white text-base">Kho tài khoản của bạn trống</h3>
                    <p class="text-xs text-gray-500">Hãy chọn mua những tài khoản game vip tuyệt vời để sở hữu thông tin đăng nhập.</p>
                    <a href="{{ route('accounts.index') }}" class="mt-2 inline-block font-bold text-xs bg-gaming-purple hover:bg-gaming-purple/80 text-white py-2 px-6 rounded-lg">MUA ACC NGAY</a>
                </div>
            @endforelse

            <!-- Pagination -->
            @if($orders->hasPages())
                <div class="mt-6 flex justify-center">
                    {{ $orders->links('pagination::tailwind') }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
