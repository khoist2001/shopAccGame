@extends('layouts.app')

@section('title', 'Chi Tiết Đơn Hàng - GameShop Admin')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <!-- Header title -->
    <div class="mb-8 border-b border-gaming-border/40 pb-5 flex items-center justify-between">
        <div class="text-left space-y-2">
            <h1 class="font-gaming font-black text-2xl tracking-wider text-white uppercase"><i class="fa-solid fa-receipt text-gaming-purple mr-2"></i>CHI TIẾT <span class="bg-gradient-to-r from-gaming-purple to-gaming-pink bg-clip-text text-transparent">ĐƠN HÀNG #{{ $order->id }}</span></h1>
            <p class="text-xs text-gray-400">Xem thông tin giao dịch, tài khoản game đã mua và thông tin bàn giao.</p>
        </div>
        <a href="{{ route('admin.orders.index') }}" class="text-xs font-bold text-gray-400 hover:text-white transition-colors bg-gaming-card border border-gaming-border px-4 py-2.5 rounded-xl"><i class="fa-solid fa-arrow-left mr-2"></i>Quay lại</a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Main Order Details -->
        <div class="md:col-span-2 space-y-6">
            <!-- Items Bought List -->
            <div class="bg-gaming-card border border-gaming-border p-6 rounded-2xl shadow-glass space-y-4">
                <h3 class="text-xs font-bold uppercase tracking-wider text-gaming-neon border-b border-gaming-border/60 pb-3"><i class="fa-solid fa-gamepad mr-2"></i>Danh sách Account đã mua</h3>
                
                <div class="divide-y divide-gaming-border/50">
                    @foreach($order->accounts as $acc)
                        <div class="py-4 flex items-start space-x-4">
                            <!-- Image -->
                            <div class="h-16 w-24 rounded bg-gaming-dark overflow-hidden border border-gaming-border/60 flex-shrink-0">
                                <img src="{{ $acc->first_image }}" class="w-full h-full object-cover">
                            </div>
                            <!-- Detail -->
                            <div class="flex-grow text-left space-y-1">
                                <span class="text-3xs font-bold uppercase text-gaming-purple bg-gaming-purple/10 px-2 py-0.5 rounded">{{ $acc->game->name }}</span>
                                <h4 class="text-sm font-bold text-white hover:text-gaming-neon transition-colors"><a href="{{ route('accounts.show', $acc->id) }}">{{ $acc->title }}</a></h4>
                                <div class="flex items-center space-x-3 text-3xs text-gray-400">
                                    <span>Hạng: <strong class="text-gaming-neon font-gaming">{{ $acc->rank ?? 'N/A' }}</strong></span>
                                    <span>Mã số: <strong>#{{ $acc->id }}</strong></span>
                                </div>

                                <!-- Credentials delivery for admin check -->
                                <div class="mt-3 bg-gaming-dark border border-gaming-border p-3 rounded-lg flex items-center justify-between">
                                    <div class="text-left">
                                        <p class="text-3xs text-gray-500 uppercase font-bold tracking-wider">Thông tin tài khoản (Bàn giao)</p>
                                        <p class="text-xs text-gaming-neon font-mono select-all font-semibold mt-1">{{ $acc->login_details }}</p>
                                    </div>
                                    <button onclick="navigator.clipboard.writeText('{{ $acc->login_details }}'); triggerToast('Đã copy tài khoản!', 'success')" class="text-xs text-gray-400 hover:text-white transition-colors pl-3"><i class="fa-solid fa-copy"></i></button>
                                </div>
                            </div>
                            <!-- Price -->
                            <div class="text-right flex-shrink-0">
                                <p class="font-gaming text-sm text-white font-bold">{{ number_format($acc->price, 0, ',', '.') }}đ</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Order Summary & Customer info -->
        <div class="space-y-6">
            <!-- Customer -->
            <div class="bg-gaming-card border border-gaming-border p-6 rounded-2xl shadow-glass text-left space-y-3">
                <h3 class="text-xs font-bold uppercase tracking-wider text-gaming-purple border-b border-gaming-border/60 pb-3"><i class="fa-solid fa-user mr-2"></i>Khách hàng</h3>
                <div class="space-y-1">
                    <p class="text-sm text-white font-bold">{{ $order->user->name ?? 'Người dùng đã bị xóa' }}</p>
                    <p class="text-xs text-gray-400 font-mono">{{ $order->user->email ?? 'N/A' }}</p>
                </div>
                <div class="pt-2 text-3xs text-gray-500">
                    <span>Đăng ký: {{ $order->user ? $order->user->created_at->format('d/m/Y') : 'N/A' }}</span>
                </div>
            </div>

            <!-- Summary -->
            <div class="bg-gaming-card border border-gaming-border p-6 rounded-2xl shadow-glass text-left space-y-4">
                <h3 class="text-xs font-bold uppercase tracking-wider text-gaming-pink border-b border-gaming-border/60 pb-3"><i class="fa-solid fa-calculator mr-2"></i>Tóm tắt chi phí</h3>
                
                <div class="space-y-2 text-xs">
                    <div class="flex justify-between">
                        <span class="text-gray-400">Tạm tính:</span>
                        <span class="font-gaming text-white">{{ number_format($order->total_amount, 0, ',', '.') }}đ</span>
                    </div>

                    @if($order->coupon)
                        <div class="flex justify-between">
                            <span class="text-gray-400">Coupon ({{ $order->coupon->code }}):</span>
                            <span class="font-gaming text-gaming-pink">-{{ number_format($order->discount_amount, 0, ',', '.') }}đ</span>
                        </div>
                    @endif

                    <div class="border-t border-gaming-border/60 pt-2 flex justify-between items-baseline">
                        <span class="text-sm font-bold text-white">Thành tiền:</span>
                        <span class="font-gaming text-lg text-gaming-neon font-black">{{ number_format($order->final_amount, 0, ',', '.') }}đ</span>
                    </div>
                </div>

                <div class="bg-gaming-dark/60 border border-gaming-border p-3 rounded-lg space-y-1 text-3xs text-gray-400">
                    <p>Mã đơn hàng: <strong class="text-gray-300">#{{ $order->id }}</strong></p>
                    <p>Thời gian mua: <strong class="text-gray-300">{{ $order->created_at->format('d/m/Y H:i:s') }}</strong></p>
                    <p>Cơ chế thanh toán: <strong class="text-gaming-neon">Trừ số dư ví tự động</strong></p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
