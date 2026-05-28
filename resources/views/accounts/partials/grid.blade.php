<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
    @forelse($accounts as $account)
        <div class="bg-gaming-card border border-gaming-border/80 hover:border-gaming-purple rounded-2xl overflow-hidden shadow-glass hover:shadow-neon-purple/20 transition-all duration-300 flex flex-col group transform hover:-translate-y-1">
            <!-- Image Frame -->
            <div class="relative h-48 overflow-hidden bg-gaming-dark">
                <img src="{{ $account->first_image }}" alt="{{ $account->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                <span class="absolute top-3 left-3 bg-gaming-purple/95 backdrop-blur-md text-white text-3xs font-black tracking-wider px-2 py-0.5 rounded uppercase font-gaming border border-white/10 shadow-neon-purple/30">
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
                        <i class="fa-solid fa-chevron-right text-sm"></i>
                    </a>
                </div>
            </div>
        </div>
    @empty
        <div class="col-span-full py-16 text-center text-gray-400 flex flex-col items-center justify-center space-y-3">
            <i class="fa-solid fa-folder-open text-4xl text-gray-600"></i>
            <p class="text-sm">Không tìm thấy tài khoản game nào phù hợp với bộ lọc.</p>
        </div>
    @endforelse
</div>

<!-- Custom Styled Pagination -->
@if($accounts->hasPages())
    <div class="mt-12 flex justify-center custom-pagination">
        {{ $accounts->links('pagination::tailwind') }}
    </div>
@endif
