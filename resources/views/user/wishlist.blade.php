@extends('layouts.app')

@section('title', 'Tài Khoản Yêu Thích - GameShop')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <!-- Breadcrumb back link -->
    <div class="mb-6 flex items-center justify-between border-b border-gaming-border/40 pb-5">
        <div class="text-left space-y-2">
            <h1 class="font-gaming font-black text-2xl tracking-wider text-white uppercase"><i class="fa-solid fa-heart text-gaming-pink mr-2"></i>DANH SÁCH <span class="bg-gradient-to-r from-gaming-purple to-gaming-pink bg-clip-text text-transparent">YÊU THÍCH</span></h1>
            <p class="text-xs text-gray-400">Các tài khoản game bạn đang theo dõi và cân nhắc sở hữu.</p>
        </div>
        
        <a href="{{ route('accounts.index') }}" class="text-xs font-semibold text-gray-400 hover:text-gaming-neon transition-colors flex items-center">
            <i class="fa-solid fa-store mr-1"></i>Vào cửa hàng
        </a>
    </div>

    <!-- Catalog Grid container -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($accounts as $account)
            <div class="bg-gaming-card border border-gaming-border/80 hover:border-gaming-purple rounded-2xl overflow-hidden shadow-glass hover:shadow-neon-purple/20 transition-all duration-300 flex flex-col group transform hover:-translate-y-1 relative">
                <!-- Remove Wishlist Button on card -->
                <form action="{{ route('wishlist.toggle', $account->id) }}" method="POST" class="absolute top-3 right-3 z-10">
                    @csrf
                    <button type="submit" class="h-8 w-8 rounded-lg bg-black/60 hover:bg-red-500 border border-white/10 hover:border-red-500 transition-all flex items-center justify-center text-red-400 hover:text-white">
                        <i class="fa-solid fa-trash-can text-sm"></i>
                    </button>
                </form>

                <!-- Image Showcase -->
                <div class="relative h-48 overflow-hidden bg-gaming-dark">
                    <img src="{{ $account->first_image }}" alt="{{ $account->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    <span class="absolute top-3 left-3 bg-gaming-purple/95 backdrop-blur-md text-white text-3xs font-black tracking-wider px-2 py-0.5 rounded uppercase font-gaming">
                        {{ $account->game->name }}
                    </span>
                    
                    @if($account->rank)
                        <span class="absolute bottom-3 right-3 bg-black/75 backdrop-blur-md text-gaming-neon text-2xs font-bold px-2 py-1 rounded border border-gaming-border/80">
                            <i class="fa-solid fa-trophy mr-1 text-3xs"></i>{{ $account->rank }}
                        </span>
                    @endif
                </div>

                <!-- Content Area -->
                <div class="p-5 flex-grow flex flex-col justify-between space-y-4">
                    <div class="space-y-1.5">
                        <h3 class="font-display font-semibold text-white group-hover:text-gaming-neon transition-colors line-clamp-1">
                            <a href="{{ route('accounts.show', $account->id) }}">{{ $account->title }}</a>
                        </h3>
                        <p class="text-xs text-gray-400 line-clamp-2 leading-relaxed">
                            {{ strip_tags($account->description) }}
                        </p>
                    </div>

                    <div class="flex items-center justify-between pt-3 border-t border-gaming-border/50">
                        <div>
                            <span class="block text-4xs text-gray-500 uppercase tracking-widest">Giá bán</span>
                            <span class="text-base font-black text-gaming-neon glow-text-neon font-gaming">{{ number_format($account->price, 0, ',', '.') }}đ</span>
                        </div>
                        
                        <a href="{{ route('accounts.show', $account->id) }}" class="bg-gaming-purple hover:bg-gaming-purple/80 text-white p-2.5 rounded-lg transition-all shadow-neon-purple/10">
                            Chi Tiết <i class="fa-solid fa-arrow-right ml-1"></i>
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full py-20 text-center text-gray-400 flex flex-col items-center justify-center space-y-3 bg-gaming-card border border-gaming-border rounded-2xl">
                <i class="fa-regular fa-heart text-5xl text-gray-600"></i>
                <h3 class="font-semibold text-white text-base">Danh sách yêu thích của bạn trống</h3>
                <p class="text-xs text-gray-500">Hãy duyệt qua các tài khoản game và nhấn thả tim để thêm vào đây!</p>
                <a href="{{ route('accounts.index') }}" class="mt-2 inline-block font-bold text-xs bg-gaming-purple hover:bg-gaming-purple/80 text-white py-2 px-5 rounded-lg">KHÁM PHÁ CỬA HÀNG</a>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($accounts->hasPages())
        <div class="mt-12 flex justify-center">
            {{ $accounts->links('pagination::tailwind') }}
        </div>
    @endif
</div>
@endsection
