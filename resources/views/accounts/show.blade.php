@extends('layouts.app')

@section('title', $account->title . ' - GameShop')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <!-- Back Navigation breadcrumb -->
    <div class="mb-6 flex items-center justify-between">
        <a href="{{ route('accounts.index') }}" class="text-sm font-semibold text-gray-400 hover:text-gaming-neon transition-colors flex items-center">
            <i class="fa-solid fa-arrow-left mr-2"></i>Quay lại danh sách
        </a>
        
        <span class="text-xs bg-gaming-card border border-gaming-border text-gray-400 py-1 px-3 rounded-full font-gaming">
            Mã số: #{{ $account->id }}
        </span>
    </div>

    <!-- Details Presentation -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start mb-16">
        
        <!-- Gallery Section (col-span-7) -->
        <div class="lg:col-span-7 space-y-4" x-data="{ 
            mainImage: '{{ $account->first_image }}',
            images: {{ json_encode($account->images ?? [$account->first_image]) }}
        }">
            <!-- Main Preview Frame -->
            <div class="w-full h-80 sm:h-[450px] bg-gaming-dark border border-gaming-border rounded-2xl overflow-hidden shadow-glass relative flex items-center justify-center">
                <img :src="mainImage" alt="Main Preview" class="w-full h-full object-cover transition-all duration-300">
                <span class="absolute top-4 left-4 bg-gaming-purple/90 backdrop-blur-md text-white text-3xs font-black tracking-wider px-2 py-0.5 rounded uppercase font-gaming">
                    {{ $account->game->name }}
                </span>
            </div>

            <!-- Gallery Thumbnails slider -->
            <div class="flex flex-wrap gap-3">
                <template x-for="(img, idx) in images" :key="idx">
                    <button @click="mainImage = img" @mouseover="mainImage = img"
                        class="h-16 w-20 rounded-xl overflow-hidden bg-gaming-dark border focus:outline-none transition-all"
                        :class="mainImage === img ? 'border-gaming-neon shadow-neon-green/20' : 'border-gaming-border hover:border-gaming-purple'">
                        <img :src="img" class="w-full h-full object-cover">
                    </button>
                </template>
            </div>
        </div>

        <!-- Spec Dashboard Panel (col-span-5) -->
        <div class="lg:col-span-5 bg-gaming-card border border-gaming-border p-6 rounded-2xl space-y-6 shadow-glass relative">
            <div class="space-y-2">
                <span class="inline-block bg-gaming-neon/20 text-gaming-neon border border-gaming-neon/30 text-xs font-bold px-2.5 py-1 rounded-md tracking-wider font-gaming uppercase">
                    {{ $account->status === 'available' ? 'Còn Hàng' : 'Hết Hàng' }}
                </span>
                <h1 class="font-display font-bold text-2xl sm:text-3xl text-white tracking-wide leading-snug">{{ $account->title }}</h1>
            </div>

            <!-- Attributes Specifications Panel -->
            <div class="grid grid-cols-2 gap-4 bg-gaming-dark/40 p-4 border border-gaming-border rounded-xl">
                <div>
                    <span class="block text-4xs text-gray-500 uppercase tracking-widest font-semibold">Tựa Game</span>
                    <span class="font-semibold text-sm text-gray-200"><i class="fa-solid fa-gamepad text-gaming-purple mr-1.5"></i>{{ $account->game->name }}</span>
                </div>
                <div>
                    <span class="block text-4xs text-gray-500 uppercase tracking-widest font-semibold">Hạng / Rank</span>
                    <span class="font-semibold text-sm text-gray-200"><i class="fa-solid fa-trophy text-gaming-neon mr-1.5"></i>{{ $account->rank ?? 'Không có' }}</span>
                </div>
                <div class="pt-3 border-t border-gaming-border/30">
                    <span class="block text-4xs text-gray-500 uppercase tracking-widest font-semibold">Giao Dịch</span>
                    <span class="font-semibold text-sm text-gray-200 text-gaming-neon font-gaming"><i class="fa-solid fa-bolt mr-1.5 text-xs"></i>Tự động 100%</span>
                </div>
                <div class="pt-3 border-t border-gaming-border/30">
                    <span class="block text-4xs text-gray-500 uppercase tracking-widest font-semibold">Bảo Hành</span>
                    <span class="font-semibold text-sm text-gray-200"><i class="fa-solid fa-shield-halved text-gaming-pink mr-1.5"></i>Trọn đời lỗi 1-1</span>
                </div>
            </div>

            <!-- Price showcase -->
            <div class="flex items-end justify-between border-b border-gaming-border pb-6">
                <div>
                    <span class="block text-xs text-gray-500 uppercase tracking-widest font-semibold">Giá trọn gói</span>
                    <span class="text-3xl font-black text-gaming-neon glow-text-neon font-gaming">{{ number_format($account->price, 0, ',', '.') }}đ</span>
                </div>
                
                @if($account->status === 'available')
                    <!-- Add to Wishlist -->
                    <form action="{{ route('wishlist.toggle', $account->id) }}" method="POST">
                        @csrf
                        <button type="submit" 
                            class="h-12 w-12 rounded-xl bg-gaming-dark hover:bg-gaming-border border border-gaming-border hover:border-gaming-pink transition-all flex items-center justify-center text-xl"
                            :class="'{{ $isWishlisted }}' ? 'text-gaming-pink border-gaming-pink' : 'text-gray-400 hover:text-gaming-pink'">
                            <i class="{{ $isWishlisted ? 'fa-solid' : 'fa-regular' }} fa-heart"></i>
                        </button>
                    </form>
                @endif
            </div>

            <!-- Purchase triggers -->
            @if($account->status === 'available')
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <!-- Add to Cart -->
                    <form action="{{ route('cart.add', $account->id) }}" method="POST">
                        @csrf
                        <button type="submit" 
                            class="w-full py-4 px-4 bg-gaming-dark hover:bg-gaming-border border border-gaming-border rounded-xl text-sm font-bold text-gray-300 hover:text-white transition-all transform hover:-translate-y-0.5">
                            <i class="fa-solid fa-basket-shopping mr-2 text-gaming-neon"></i>THÊM VÀO GIỎ
                        </button>
                    </form>

                    <!-- Buy Now Directly -->
                    <form action="{{ route('cart.buy-now', $account->id) }}" method="POST">
                        @csrf
                        <button type="submit" 
                            class="w-full py-4 px-4 bg-gradient-to-r from-gaming-purple to-gaming-pink text-sm font-bold text-white rounded-xl shadow-neon-purple/20 hover:opacity-90 transition-all transform hover:-translate-y-0.5">
                            <i class="fa-solid fa-bolt-lightning mr-2"></i>MUA NGAY
                        </button>
                    </form>
                </div>
            @else
                <button disabled class="w-full py-4 px-4 bg-gaming-border border border-gaming-border rounded-xl text-sm font-bold text-gray-500 cursor-not-allowed">
                    TÀI KHOẢN ĐÃ ĐƯỢC BÁN
                </button>
            @endif
        </div>
    </div>

    <!-- Description & login credentials documentation -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start mb-16">
        <div class="lg:col-span-12 bg-gaming-card border border-gaming-border p-8 rounded-2xl shadow-glass space-y-6">
            <h2 class="font-display font-bold text-xl text-white border-b border-gaming-border pb-4 flex items-center">
                <i class="fa-solid fa-circle-info text-gaming-purple mr-3"></i>Mô Tả & Thông Tin Chi Tiết
            </h2>
            
            <div class="text-gray-300 text-sm leading-relaxed space-y-4 prose prose-invert max-w-none">
                {!! nl2br(e($account->description)) !!}
            </div>
        </div>
    </div>

    <!-- Related Products -->
    @if($relatedAccounts->isNotEmpty())
        <div class="space-y-6">
            <h2 class="font-gaming font-black text-2xl tracking-wider text-white uppercase"><i class="fa-solid fa-circle-nodes text-gaming-pink mr-2"></i>TÀI KHOẢN <span class="bg-gradient-to-r from-gaming-purple to-gaming-pink bg-clip-text text-transparent">LIÊN QUAN</span></h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($relatedAccounts as $related)
                    <div class="bg-gaming-card border border-gaming-border/80 hover:border-gaming-purple rounded-2xl overflow-hidden shadow-glass hover:shadow-neon-purple/20 transition-all duration-300 flex flex-col group transform hover:-translate-y-1">
                        <!-- Related Product Image -->
                        <div class="relative h-44 overflow-hidden bg-gaming-dark">
                            <img src="{{ $related->first_image }}" alt="{{ $related->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            <span class="absolute top-3 left-3 bg-gaming-purple/95 backdrop-blur-md text-white text-3xs font-black tracking-wider px-2 py-0.5 rounded uppercase font-gaming">
                                {{ $related->game->name }}
                            </span>
                            
                            @if($related->rank)
                                <span class="absolute bottom-3 right-3 bg-black/75 backdrop-blur-md text-gaming-neon text-2xs font-bold px-2 py-1 rounded border border-gaming-border/80">
                                    <i class="fa-solid fa-trophy mr-1 text-3xs"></i>{{ $related->rank }}
                                </span>
                            @endif
                        </div>

                        <!-- Related Product Details -->
                        <div class="p-4 flex-grow flex flex-col justify-between space-y-3">
                            <h3 class="font-display font-semibold text-white group-hover:text-gaming-neon transition-colors line-clamp-1">
                                <a href="{{ route('accounts.show', $related->id) }}">{{ $related->title }}</a>
                            </h3>
                            <div class="flex items-center justify-between pt-2 border-t border-gaming-border/50">
                                <span class="text-sm font-black text-gaming-neon glow-text-neon font-gaming">{{ number_format($related->price, 0, ',', '.') }}đ</span>
                                <a href="{{ route('accounts.show', $related->id) }}" class="bg-gaming-purple hover:bg-gaming-purple/80 text-white p-2 rounded-lg transition-all">
                                    <i class="fa-solid fa-chevron-right text-xs"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>
@endsection
