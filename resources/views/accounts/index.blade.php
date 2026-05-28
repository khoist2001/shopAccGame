@extends('layouts.app')

@section('title', 'Danh Sách Account Game - GameShop')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <!-- Top Catalog Header -->
    <div class="text-left space-y-3 mb-10">
        <h1 class="font-gaming font-black text-3xl tracking-wider text-white uppercase"><i class="fa-solid fa-store text-gaming-neon mr-2"></i>KHO <span class="bg-gradient-to-r from-gaming-purple to-gaming-pink bg-clip-text text-transparent">ACCOUNT</span> GAME</h1>
        <p class="text-sm text-gray-400">Lựa chọn hàng ngàn tài khoản game vip chất lượng, giao dịch hoàn toàn tự động.</p>
    </div>

    <!-- Catalog Main Area -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start" x-data="filterManager()">
        <!-- Sidebar Filter (Lg: col-span-3) -->
        <div class="lg:col-span-3 bg-gaming-card border border-gaming-border p-6 rounded-2xl space-y-6 shadow-glass relative">
            <h2 class="font-display font-bold text-lg text-white border-b border-gaming-border pb-3 flex items-center justify-between">
                <span>Bộ Lọc Tìm Kiếm</span>
                <i class="fa-solid fa-filter text-gaming-neon text-sm"></i>
            </h2>

            <form id="filterForm" @submit.prevent="applyFilters">
                <!-- Search term -->
                <div class="space-y-2 mb-4">
                    <label class="block text-xs font-semibold uppercase tracking-wider text-gray-400">Từ Khóa</label>
                    <div class="relative">
                        <input type="text" name="q" x-model="filters.q" @input.debounce.500ms="applyFilters"
                            class="bg-gaming-dark/60 block w-full pl-3 pr-10 py-2.5 border border-gaming-border rounded-xl text-gray-200 placeholder-gray-500 text-sm focus:outline-none focus:border-gaming-purple focus:ring-1 focus:ring-gaming-purple transition-all" 
                            placeholder="Mã số, tên skin, tướng...">
                        <span class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-500"><i class="fa-solid fa-magnifying-glass text-sm"></i></span>
                    </div>
                </div>

                <!-- Game selector -->
                <div class="space-y-2 mb-4">
                    <label class="block text-xs font-semibold uppercase tracking-wider text-gray-400">Tựa Game</label>
                    <select name="game" x-model="filters.game" @change="applyFilters"
                        class="bg-gaming-dark block w-full px-3 py-2.5 border border-gaming-border rounded-xl text-gray-200 text-sm focus:outline-none focus:border-gaming-purple focus:ring-1 focus:ring-gaming-purple">
                        <option value="">Tất cả game</option>
                        @foreach($games as $game)
                            <option value="{{ $game->slug }}">{{ $game->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Rank Selector -->
                <div class="space-y-2 mb-4">
                    <label class="block text-xs font-semibold uppercase tracking-wider text-gray-400">Hạng / Rank</label>
                    <select name="rank" x-model="filters.rank" @change="applyFilters"
                        class="bg-gaming-dark block w-full px-3 py-2.5 border border-gaming-border rounded-xl text-gray-200 text-sm focus:outline-none focus:border-gaming-purple focus:ring-1 focus:ring-gaming-purple">
                        <option value="">Tất cả rank</option>
                        @foreach($ranks as $rank)
                            <option value="{{ $rank }}">{{ $rank }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Price inputs -->
                <div class="space-y-2 mb-6">
                    <label class="block text-xs font-semibold uppercase tracking-wider text-gray-400">Giá Bán</label>
                    <div class="grid grid-cols-2 gap-2">
                        <input type="number" name="price_min" x-model="filters.price_min" @input.debounce.500ms="applyFilters"
                            class="bg-gaming-dark/60 block w-full px-3 py-2 border border-gaming-border rounded-xl text-gray-200 placeholder-gray-600 text-sm focus:outline-none focus:border-gaming-purple focus:ring-1 focus:ring-gaming-purple"
                            placeholder="Từ đ">
                        <input type="number" name="price_max" x-model="filters.price_max" @input.debounce.500ms="applyFilters"
                            class="bg-gaming-dark/60 block w-full px-3 py-2 border border-gaming-border rounded-xl text-gray-200 placeholder-gray-600 text-sm focus:outline-none focus:border-gaming-purple focus:ring-1 focus:ring-gaming-purple"
                            placeholder="Đến đ">
                    </div>
                </div>

                <!-- Reset button -->
                <button type="button" @click="resetFilters"
                    class="w-full py-2.5 border border-gaming-border rounded-xl text-xs font-semibold text-gray-400 hover:text-white hover:bg-gaming-dark transition-all">
                    Xóa Bộ Lọc
                </button>
            </form>
        </div>

        <!-- Catalog Listing Grid (Lg: col-span-9) -->
        <div class="lg:col-span-9 space-y-6 relative min-h-[50vh]">
            <!-- Filters & Sort Header bar -->
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between bg-gaming-card border border-gaming-border p-4 rounded-2xl gap-4 shadow-glass">
                <span class="text-xs text-gray-400 font-bold uppercase tracking-wider">
                    Hiển thị <span class="text-gaming-neon" x-text="count">0</span> tài khoản đang bán
                </span>
                
                <!-- Sort option -->
                <div class="flex items-center space-x-2">
                    <span class="text-xs text-gray-500 font-semibold">Sắp xếp:</span>
                    <select x-model="filters.sort" @change="applyFilters"
                        class="bg-gaming-dark border border-gaming-border rounded-xl px-3 py-1.5 text-xs text-gray-300 focus:outline-none focus:border-gaming-purple">
                        <option value="latest">Mới nhất</option>
                        <option value="price_asc">Giá tăng dần</option>
                        <option value="price_desc">Giá giảm dần</option>
                    </select>
                </div>
            </div>

            <!-- Loading Spinner Spinner overlay -->
            <div x-show="loading" x-cloak
                class="absolute inset-0 bg-gaming-dark/60 backdrop-blur-sm rounded-2xl flex items-center justify-center z-20">
                <div class="flex flex-col items-center space-y-3">
                    <i class="fa-solid fa-spinner fa-spin text-4xl text-gaming-neon"></i>
                    <p class="text-xs text-gaming-neon font-bold tracking-wider font-gaming">ĐANG TẢI DỮ LIỆU...</p>
                </div>
            </div>

            <!-- Accounts Card Grid Container -->
            <div id="accountsGrid" class="transition-all duration-300">
                @include('accounts.partials.grid')
            </div>
        </div>
    </div>
</div>

<!-- AJAX and Alpine.js Filtering Script -->
<script>
    function filterManager() {
        return {
            loading: false,
            count: {{ $accounts->total() }},
            filters: {
                q: '{{ request()->q }}',
                game: '{{ request()->game }}',
                rank: '{{ request()->rank }}',
                price_min: '{{ request()->price_min }}',
                price_max: '{{ request()->price_max }}',
                sort: 'latest',
                page: 1
            },
            init() {
                // Intercept pagination clicks dynamically
                document.addEventListener('click', (e) => {
                    const pageLink = e.target.closest('.custom-pagination a');
                    if (pageLink) {
                        e.preventDefault();
                        const url = new URL(pageLink.href);
                        this.filters.page = url.searchParams.get('page') || 1;
                        this.fetchData();
                    }
                });
            },
            applyFilters() {
                this.filters.page = 1; // Reset to page 1 on filter modification
                this.fetchData();
            },
            resetFilters() {
                this.filters = {
                    q: '',
                    game: '',
                    rank: '',
                    price_min: '',
                    price_max: '',
                    sort: 'latest',
                    page: 1
                };
                this.fetchData();
            },
            fetchData() {
                this.loading = true;
                
                // Formulate query params
                const params = new URLSearchParams();
                for (const [key, value] of Object.entries(this.filters)) {
                    if (value) params.append(key, value);
                }
                
                const fetchUrl = `${window.location.pathname}?${params.toString()}`;
                
                // Push new history state without reloading
                window.history.pushState({}, '', fetchUrl);
                
                fetch(fetchUrl, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(res => res.text())
                .then(html => {
                    document.getElementById('accountsGrid').innerHTML = html;
                    
                    // Parse total count if present in response
                    const paginationLinks = document.querySelector('.custom-pagination');
                    // Recalculate count
                    const visibleCards = document.querySelectorAll('#accountsGrid .grid > div').length;
                    this.count = visibleCards; // Update display counts dynamically
                })
                .catch(err => {
                    console.error("Fetch errors: ", err);
                })
                .finally(() => {
                    this.loading = false;
                });
            }
        }
    }
</script>
@endsection
