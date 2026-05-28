@extends('layouts.app')

@section('title', 'Giỏ Hàng - GameShop')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12" x-data="{ isConfirmModalOpen: false }">
    <!-- Catalog Header -->
    <div class="mb-10 border-b border-gaming-border/40 pb-5">
        <h1 class="font-gaming font-black text-2xl tracking-wider text-white uppercase"><i class="fa-solid fa-basket-shopping text-gaming-neon mr-2"></i>GIỎ HÀNG <span class="bg-gradient-to-r from-gaming-purple to-gaming-pink bg-clip-text text-transparent">CỦA BẠN</span></h1>
        <p class="text-xs text-gray-400">Kiểm tra lại các tài khoản game và thực hiện thanh toán an toàn qua số dư ví.</p>
    </div>

    @if(empty($accounts) || count($accounts) === 0)
        <!-- Empty Cart -->
        <div class="py-20 text-center text-gray-400 flex flex-col items-center justify-center space-y-4 bg-gaming-card border border-gaming-border rounded-2xl">
            <i class="fa-solid fa-basket-shopping text-5xl text-gray-600"></i>
            <h3 class="font-semibold text-white text-base">Giỏ hàng của bạn đang trống</h3>
            <p class="text-xs text-gray-500">Hãy thêm một số tài khoản game tuyệt vời vào giỏ hàng để bắt đầu thanh toán.</p>
            <a href="{{ route('accounts.index') }}" class="mt-2 inline-block font-bold text-xs bg-gaming-purple hover:bg-gaming-purple/80 text-white py-2 px-6 rounded-lg">MUA ACC NGAY</a>
        </div>
    @else
        <!-- Cart grid layout -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            <!-- Items list (col-span-8) -->
            <div class="lg:col-span-8 space-y-4">
                @foreach($accounts as $account)
                    <div class="bg-gaming-card border border-gaming-border p-4 rounded-xl flex items-center justify-between gap-4 shadow-glass relative group">
                        <!-- Remove button -->
                        <form action="{{ route('cart.remove', $account->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="absolute top-3 right-3 text-gray-500 hover:text-red-400 transition-colors">
                                <i class="fa-solid fa-xmark"></i>
                            </button>
                        </form>

                        <div class="flex items-center space-x-4">
                            <!-- Thumbnail -->
                            <div class="h-16 w-24 rounded-lg overflow-hidden bg-gaming-dark flex-shrink-0 border border-gaming-border">
                                <img src="{{ $account->first_image }}" class="w-full h-full object-cover">
                            </div>
                            <!-- Title & Spec -->
                            <div>
                                <span class="text-3xs bg-gaming-purple/20 text-gaming-purple border border-gaming-purple/30 px-2 py-0.5 rounded uppercase font-gaming font-bold">
                                    {{ $account->game->name }}
                                </span>
                                <h3 class="font-display font-semibold text-white text-sm sm:text-base mt-1 line-clamp-1">
                                    <a href="{{ route('accounts.show', $account->id) }}" class="hover:text-gaming-neon transition-colors">{{ $account->title }}</a>
                                </h3>
                                <p class="text-xs text-gray-400 mt-0.5 flex items-center gap-3">
                                    <span><i class="fa-solid fa-trophy text-gaming-neon mr-1"></i>Rank: {{ $account->rank ?? 'N/A' }}</span>
                                    <span>• Mã số: #{{ $account->id }}</span>
                                </p>
                            </div>
                        </div>

                        <!-- Price -->
                        <div class="text-right pr-6 flex-shrink-0">
                            <span class="block text-4xs text-gray-500 uppercase tracking-widest">Đơn giá</span>
                            <span class="text-sm sm:text-base font-black text-gaming-neon font-gaming">{{ number_format($account->price, 0, ',', '.') }}đ</span>
                        </div>
                    </div>
                @endforeach

                <!-- Coupon Applicator Box -->
                <div class="bg-gaming-card border border-gaming-border p-5 rounded-xl shadow-glass flex flex-col sm:flex-row items-center justify-between gap-4">
                    <div class="space-y-1 text-center sm:text-left">
                        <h3 class="font-semibold text-white text-sm"><i class="fa-solid fa-ticket text-gaming-purple mr-2"></i>Mã Giảm Giá (Coupon)</h3>
                        <p class="text-xs text-gray-400">Nhập mã ưu đãi để nhận chiết khấu trực tiếp vào đơn hàng.</p>
                    </div>

                    @if($coupon)
                        <!-- Coupon Applied -->
                        <div class="flex items-center space-x-3 bg-gaming-dark/60 py-1.5 px-3 border border-gaming-neon/40 rounded-xl text-gaming-neon text-xs">
                            <span class="font-bold font-gaming">{{ $coupon->code }}</span>
                            <span>(-{{ $coupon->discount_type === 'percent' ? $coupon->discount_amount . '%' : number_format($coupon->discount_amount, 0, ',', '.') . 'đ' }})</span>
                            
                            <form action="{{ route('cart.coupon.remove') }}" method="POST">
                                @csrf
                                <button type="submit" class="text-red-400 hover:text-white pl-2">
                                    <i class="fa-solid fa-circle-xmark"></i>
                                </button>
                            </form>
                        </div>
                    @else
                        <!-- Form to Apply -->
                        <form action="{{ route('cart.coupon.apply') }}" method="POST" class="flex w-full sm:w-auto max-w-sm">
                            @csrf
                            <input type="text" name="code" required uppercase
                                class="bg-gaming-dark/60 block w-full px-3 py-2 border border-gaming-border rounded-l-xl text-gray-200 uppercase placeholder-gray-600 text-xs focus:outline-none focus:border-gaming-purple"
                                placeholder="Mã giảm giá">
                            <button type="submit"
                                class="bg-gaming-purple hover:bg-gaming-purple/80 text-white font-bold text-xs px-4 rounded-r-xl transition-all">
                                ÁP DỤNG
                            </button>
                        </form>
                    @endif
                </div>
            </div>

            <!-- Checkout Summary (col-span-4) -->
            <div class="lg:col-span-4 bg-gaming-card border border-gaming-border p-6 rounded-2xl space-y-6 shadow-glass relative">
                <h2 class="font-display font-bold text-lg text-white border-b border-gaming-border pb-3 flex items-center">
                    <i class="fa-solid fa-file-invoice-dollar text-gaming-neon mr-3"></i>Tóm tắt đơn hàng
                </h2>

                <div class="space-y-3 text-sm text-gray-300">
                    <div class="flex justify-between">
                        <span>Tạm tính</span>
                        <span class="font-semibold text-gray-200">{{ number_format($subtotal, 0, ',', '.') }}đ</span>
                    </div>

                    @if($discount > 0)
                        <div class="flex justify-between text-gaming-pink">
                            <span>Giảm giá</span>
                            <span class="font-semibold">-{{ number_format($discount, 0, ',', '.') }}đ</span>
                        </div>
                    @endif

                    <hr class="border-gaming-border">

                    <div class="flex justify-between items-end">
                        <span class="font-bold text-white">Tổng cộng</span>
                        <span class="text-2xl font-black text-gaming-neon glow-text-neon font-gaming">{{ number_format($total, 0, ',', '.') }}đ</span>
                    </div>
                </div>

                <!-- Wallet balance display & validator -->
                @auth
                    <div class="bg-gaming-dark/40 border border-gaming-border p-4 rounded-xl space-y-2">
                        <div class="flex justify-between items-center text-xs">
                            <span class="text-gray-400 font-semibold uppercase tracking-wider"><i class="fa-solid fa-wallet text-gaming-purple mr-1.5"></i>Số dư ví của bạn</span>
                            <span class="font-bold text-gaming-neon">{{ number_format(Auth::user()->balance, 0, ',', '.') }}đ</span>
                        </div>
                        
                        @if(Auth::user()->balance < $total)
                            <div class="text-3xs text-red-400 bg-red-950/20 border border-red-500/20 p-2 rounded-lg leading-relaxed flex items-start">
                                <i class="fa-solid fa-circle-exclamation mr-1.5 mt-0.5"></i>
                                <span>Số dư không đủ. Vui lòng nạp thêm ít nhất {{ number_format($total - Auth::user()->balance, 0, ',', '.') }}đ để thanh toán đơn hàng này.</span>
                            </div>
                        @else
                            <div class="text-3xs text-gaming-neon bg-green-950/20 border border-gaming-neon/20 p-2 rounded-lg leading-relaxed flex items-start">
                                <i class="fa-solid fa-circle-check mr-1.5 mt-0.5"></i>
                                <span>Số dư ví hoàn toàn hợp lệ để thanh toán đơn hàng này.</span>
                            </div>
                        @endif
                    </div>

                    @if(Auth::user()->balance >= $total)
                        <!-- Checkout Trigger Button -->
                        <button @click="isConfirmModalOpen = true"
                            class="w-full py-4 bg-gradient-to-r from-gaming-purple to-gaming-pink text-sm font-bold text-white rounded-xl shadow-neon-purple/20 hover:opacity-90 transition-all transform hover:-translate-y-0.5">
                            <i class="fa-solid fa-credit-card mr-2 animate-pulse"></i>THANH TOÁN NGAY
                        </button>
                    @else
                        <!-- Deposit Link Button -->
                        <a href="{{ route('user.deposit') }}"
                            class="w-full inline-block text-center py-4 bg-gaming-border hover:bg-gaming-border/80 border border-gaming-border hover:border-gaming-neon rounded-xl text-sm font-bold text-gaming-neon hover:text-white transition-all transform hover:-translate-y-0.5">
                            <i class="fa-solid fa-wallet mr-2"></i>NẠP TIỀN VÀO VÍ
                        </a>
                    @endif
                @else
                    <!-- Alert to Log in -->
                    <div class="bg-gaming-dark/40 border border-gaming-border p-4 rounded-xl text-center space-y-3">
                        <p class="text-xs text-gray-400 leading-relaxed">Bạn cần đăng nhập tài khoản để thực hiện giao dịch thanh toán mua account.</p>
                        <a href="{{ route('login') }}" class="inline-block bg-gaming-purple hover:bg-gaming-purple/80 text-white font-bold text-xs py-2 px-5 rounded-lg w-full">ĐĂNG NHẬP</a>
                    </div>
                @endauth
            </div>
        </div>
    @endif

    <!-- Checkout Confirmation Modal -->
    <div x-show="isConfirmModalOpen" x-cloak
        class="fixed inset-0 z-50 flex items-center justify-center bg-black/85 backdrop-blur-sm p-4">
        
        <div @click.away="isConfirmModalOpen = false" x-transition
            class="bg-gaming-card border border-gaming-border max-w-md w-full rounded-2xl p-6 shadow-glass relative overflow-hidden text-center space-y-6">
            
            <div class="mx-auto h-14 w-14 rounded-full bg-gaming-purple/20 border border-gaming-purple/40 text-gaming-purple flex items-center justify-center text-2xl shadow-neon-purple/20">
                <i class="fa-solid fa-circle-question animate-bounce"></i>
            </div>

            <div class="space-y-2">
                <h3 class="font-gaming font-bold text-xl text-white uppercase tracking-wider">Xác Nhận Mua Account?</h3>
                <p class="text-xs text-gray-400 leading-relaxed">Hệ thống sẽ tự động trừ số dư ví ảo của bạn số tiền <span class="font-bold text-gaming-neon">{{ number_format($total, 0, ',', '.') }}đ</span> để hoàn tất đơn hàng.</p>
            </div>

            <div class="flex gap-4">
                <button @click="isConfirmModalOpen = false"
                    class="w-1/2 py-3 border border-gaming-border hover:bg-gaming-dark rounded-xl text-xs font-semibold text-gray-400 hover:text-white transition-all">
                    HỦY GIAO DỊCH
                </button>
                
                <form action="{{ route('cart.checkout') }}" method="POST" class="w-1/2">
                    @csrf
                    <button type="submit"
                        class="w-full py-3 bg-gradient-to-r from-gaming-purple to-gaming-pink text-xs font-bold text-white rounded-xl shadow-neon-purple/25">
                        XÁC NHẬN MUA
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
