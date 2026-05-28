@extends('layouts.app')

@section('title', 'GameShop - Shop Mua Bán Account Game Chuyên Nghiệp')

@section('content')
<!-- Hero Banner Section -->
<section class="relative overflow-hidden py-24 sm:py-32 flex items-center min-h-[85vh]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
        <!-- Hero Text -->
        <div class="lg:col-span-7 space-y-6 text-center lg:text-left">
            <div class="inline-flex items-center space-x-2 bg-gaming-purple/20 border border-gaming-purple/40 rounded-full py-1.5 px-4 text-xs font-bold text-gaming-neon tracking-wide uppercase animate-pulse shadow-neon-purple/25">
                <i class="fa-solid fa-fire-flame-curved"></i>
                <span>Hệ Thống Giao Dịch Tự Động 100%</span>
            </div>
            
            <h1 class="font-display font-black text-4xl sm:text-5xl lg:text-6xl tracking-tight leading-tight">
                SỞ HỮU ACCOUNT <br>
                <span class="bg-gradient-to-r from-gaming-purple via-gaming-pink to-gaming-neon bg-clip-text text-transparent font-gaming uppercase tracking-wider glow-text-purple">VIP CỰC ĐỈNH</span> <br>
                CHINH PHỤC ĐỈNH CAO
            </h1>
            
            <p class="text-base sm:text-lg text-gray-400 max-w-xl mx-auto lg:mx-0 leading-relaxed">
                GameShop cung cấp kho tài khoản game Liên Minh Huyền Thoại, Valorant, Free Fire,... chất lượng, bảo hành trọn đời, hỗ trợ 24/7. An toàn - Uy tín - Giá rẻ.
            </p>
            
            <!-- CTAs -->
            <div class="flex flex-col sm:flex-row items-center justify-center lg:justify-start gap-4 pt-4">
                <a href="{{ route('accounts.index') }}" class="w-full sm:w-auto text-center font-bold px-8 py-4 rounded-xl bg-gradient-to-r from-gaming-purple to-gaming-pink text-white hover:opacity-90 transition-all shadow-neon-purple/40 transform hover:-translate-y-0.5 tracking-wider"><i class="fa-solid fa-gamepad mr-2"></i>MUA ACC NGAY</a>
                <a href="#thongke" class="w-full sm:w-auto text-center font-bold px-8 py-4 rounded-xl border border-gaming-border hover:bg-gaming-card text-gray-300 hover:text-white transition-all tracking-wider"><i class="fa-solid fa-chart-line mr-2"></i>XEM THỐNG KÊ</a>
            </div>
        </div>
        
        <!-- Hero Visual Banner Card -->
        <div class="lg:col-span-5 relative flex justify-center">
            <div class="relative w-80 h-96 sm:w-96 sm:h-[450px] bg-gaming-card border border-gaming-border rounded-2xl p-4 shadow-glass transform rotate-3 hover:rotate-0 transition-transform duration-500 overflow-hidden group">
                <div class="absolute inset-0 bg-gradient-to-t from-gaming-dark via-transparent to-transparent opacity-90 z-10"></div>
                <img src="https://images.unsplash.com/photo-1542751371-adc38448a05e?q=80&w=800" alt="Gaming Banner Visual" class="w-full h-full object-cover rounded-xl group-hover:scale-105 transition-transform duration-700">
                
                <!-- Floating Info Badges on visual -->
                <div class="absolute bottom-6 left-6 right-6 z-20 space-y-2">
                    <span class="inline-block bg-gaming-neon text-gaming-dark text-xs font-black px-2.5 py-1 rounded-md tracking-wider font-gaming">HOT ACC</span>
                    <h3 class="font-gaming font-bold text-lg text-white tracking-wide uppercase drop-shadow-md">VALORANT RADIANT ACC</h3>
                    <p class="text-xs text-gaming-neon font-bold flex items-center"><i class="fa-solid fa-tags mr-1"></i> Giá chỉ từ 250k đ</p>
                </div>
            </div>
            <!-- Decorative light lines behind image -->
            <div class="absolute -right-4 top-1/4 w-32 h-32 bg-gaming-neon/20 rounded-full blur-3xl pointer-events-none"></div>
            <div class="absolute -left-4 bottom-1/4 w-32 h-32 bg-gaming-pink/20 rounded-full blur-3xl pointer-events-none"></div>
        </div>
    </div>
</section>

<!-- Game Categories Grid -->
<section class="py-20 border-t border-gaming-border/40 relative">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-3xl mx-auto space-y-3 mb-16">
            <h2 class="font-gaming font-black text-3xl sm:text-4xl tracking-wider text-white uppercase"><span class="text-gaming-neon">DANH MỤC</span> TRÒ CHƠI</h2>
            <div class="h-1.5 w-24 bg-gradient-to-r from-gaming-purple to-gaming-neon mx-auto rounded-full"></div>
            <p class="text-sm text-gray-400">Chọn tựa game yêu thích để lọc danh sách account phù hợp nhất với phong cách của bạn</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($games as $game)
                <a href="{{ route('accounts.index') }}?game={{ $game->slug }}" 
                    class="bg-gaming-card border border-gaming-border hover:border-gaming-purple/60 rounded-2xl p-5 shadow-glass text-center hover:shadow-neon-purple/20 transition-all duration-300 transform hover:-translate-y-1.5 group flex flex-col items-center">
                    
                    <div class="h-20 w-20 rounded-xl overflow-hidden bg-gaming-dark mb-4 border border-gaming-border group-hover:border-gaming-purple transition-all relative">
                        <img src="{{ $game->image ?? 'https://api.dicebear.com/7.x/identicon/svg?seed=' . $game->slug }}" alt="{{ $game->name }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                    </div>
                    
                    <h3 class="font-display font-bold text-lg text-white group-hover:text-gaming-neon transition-colors">{{ $game->name }}</h3>
                    <p class="text-xs text-gray-400 mt-1 leading-relaxed">{{ $game->description ?? 'Acc ngon, giá rẻ, bảo hành trọn đời.' }}</p>
                    
                    <span class="mt-4 bg-gaming-dark font-bold text-xs py-1.5 px-3 rounded-full text-gaming-purple group-hover:bg-gaming-purple group-hover:text-white transition-all">
                        {{ $game->accounts_count }} Acc có sẵn
                    </span>
                </a>
            @endforeach
        </div>
    </div>
</section>

<!-- Featured Accounts Showcase -->
<section class="py-20 bg-gaming-card/30 border-t border-gaming-border/40 relative">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row items-center justify-between mb-16 gap-4">
            <div class="text-left space-y-3">
                <h2 class="font-gaming font-black text-3xl tracking-wider text-white uppercase"><i class="fa-solid fa-star text-gaming-neon mr-2"></i>ACCOUNT <span class="bg-gradient-to-r from-gaming-purple to-gaming-pink bg-clip-text text-transparent">NỔI BẬT</span></h2>
                <p class="text-sm text-gray-400">Tuyển tập những tài khoản game VIP, rank cao, nhiều skin súng và tướng cực đỉnh</p>
            </div>
            <a href="{{ route('accounts.index') }}" class="font-bold text-sm text-gaming-neon hover:text-white transition-colors group flex items-center">
                Xem Tất Cả Account <i class="fa-solid fa-arrow-right ml-2 group-hover:translate-x-1.5 transition-transform"></i>
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @forelse($featuredAccounts as $account)
                <div class="bg-gaming-card border border-gaming-border/80 hover:border-gaming-purple rounded-2xl overflow-hidden shadow-glass hover:shadow-neon-purple/20 transition-all duration-300 flex flex-col group transform hover:-translate-y-1">
                    <!-- Image Showcase -->
                    <div class="relative h-48 overflow-hidden bg-gaming-dark">
                        <img src="{{ $account->first_image }}" alt="{{ $account->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        <span class="absolute top-3 left-3 bg-gaming-purple/90 backdrop-blur-md text-white text-3xs font-black tracking-wider px-2 py-0.5 rounded uppercase font-gaming border border-white/10 shadow-neon-purple/30">
                            {{ $account->game->name }}
                        </span>
                        
                        @if($account->rank)
                            <span class="absolute bottom-3 right-3 bg-black/75 backdrop-blur-md text-gaming-neon text-2xs font-bold px-2 py-1 rounded border border-gaming-border/80">
                                <i class="fa-solid fa-trophy mr-1 text-3xs"></i>{{ $account->rank }}
                            </span>
                        @endif
                    </div>

                    <!-- Details content -->
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
                <div class="col-span-full py-12 text-center text-gray-400">
                    Hiện chưa có account nổi bật nào. Vui lòng quay lại sau!
                </div>
            @endforelse
        </div>
    </div>
</section>

<!-- Aggregated Stats counters section -->
<section id="thongke" class="py-16 bg-gaming-dark relative overflow-hidden border-t border-gaming-border/40">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8 md:gap-4 text-center">
            <!-- Stat 1 -->
            <div class="space-y-2 border-r border-gaming-border/50 last:border-0">
                <div class="inline-flex items-center justify-center h-12 w-12 bg-gaming-purple/20 text-gaming-purple rounded-xl border border-gaming-purple/30 mb-2">
                    <i class="fa-solid fa-gamepad text-xl"></i>
                </div>
                <div class="text-3xl font-black text-white font-gaming" x-data="{ count: 0 }" x-init="setTimeout(() => count = {{ $stats['accounts_available'] }}, 200)" x-text="count">0</div>
                <p class="text-xs text-gray-400 uppercase tracking-widest font-semibold">Acc Đang Bán</p>
            </div>
            
            <!-- Stat 2 -->
            <div class="space-y-2 border-r border-gaming-border/50 last:border-0">
                <div class="inline-flex items-center justify-center h-12 w-12 bg-gaming-neon/20 text-gaming-neon rounded-xl border border-gaming-neon/30 mb-2">
                    <i class="fa-solid fa-handshake-angle text-xl"></i>
                </div>
                <div class="text-3xl font-black text-white font-gaming" x-data="{ count: 0 }" x-init="setTimeout(() => count = {{ $stats['accounts_sold'] }}, 200)" x-text="count">0</div>
                <p class="text-xs text-gray-400 uppercase tracking-widest font-semibold">Đã Bán Thành Công</p>
            </div>

            <!-- Stat 3 -->
            <div class="space-y-2 border-r border-gaming-border/50 last:border-0">
                <div class="inline-flex items-center justify-center h-12 w-12 bg-gaming-pink/20 text-gaming-pink rounded-xl border border-gaming-pink/30 mb-2">
                    <i class="fa-solid fa-users text-xl"></i>
                </div>
                <div class="text-3xl font-black text-white font-gaming" x-data="{ count: 0 }" x-init="setTimeout(() => count = {{ $stats['active_users'] }}, 200)" x-text="count">0</div>
                <p class="text-xs text-gray-400 uppercase tracking-widest font-semibold">Thành Viên Hoạt Động</p>
            </div>

            <!-- Stat 4 -->
            <div class="space-y-2 border-r border-gaming-border/50 last:border-0">
                <div class="inline-flex items-center justify-center h-12 w-12 bg-gaming-blue/20 text-gaming-blue rounded-xl border border-gaming-blue/30 mb-2">
                    <i class="fa-solid fa-shield-halved text-xl"></i>
                </div>
                <div class="text-3xl font-black text-white font-gaming" x-text="'{{ $stats['success_rate'] }}%'">0%</div>
                <p class="text-xs text-gray-400 uppercase tracking-widest font-semibold">Tỷ Lệ Hài Lòng</p>
            </div>
        </div>
    </div>
</section>

<!-- FAQs support Section -->
<section class="py-20 border-t border-gaming-border/40 relative">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center space-y-3 mb-16">
            <h2 class="font-gaming font-black text-3xl tracking-wider text-white uppercase">CÂU HỎI <span class="text-gaming-purple">THƯỜNG GẶP</span></h2>
            <div class="h-1.5 w-16 bg-gradient-to-r from-gaming-purple to-gaming-neon mx-auto rounded-full"></div>
            <p class="text-sm text-gray-400">Những thắc mắc thường gặp của các chiến binh khi mua sắm tại GameShop</p>
        </div>

        <div class="space-y-4" x-data="{ activeFaq: null }">
            <!-- FAQ 1 -->
            <div class="bg-gaming-card border border-gaming-border rounded-xl overflow-hidden transition-all">
                <button @click="activeFaq = (activeFaq === 1 ? null : 1)" class="w-full text-left p-5 flex items-center justify-between focus:outline-none">
                    <span class="font-semibold text-white text-sm sm:text-base hover:text-gaming-neon transition-colors"><i class="fa-solid fa-circle-question mr-3 text-gaming-purple"></i>Làm thế nào để nhận tài khoản sau khi mua?</span>
                    <i class="fa-solid" :class="activeFaq === 1 ? 'fa-chevron-up text-gaming-neon' : 'fa-chevron-down text-gray-400'"></i>
                </button>
                <div x-show="activeFaq === 1" x-collapse x-transition class="px-5 pb-5 border-t border-gaming-border/50 pt-4 text-sm text-gray-400 leading-relaxed bg-gaming-dark/20">
                    Hệ thống của GameShop vận hành tự động 100%. Sau khi bạn thanh toán thành công, tài khoản game (bao gồm tên đăng nhập, mật khẩu và hướng dẫn đổi mật khẩu) sẽ hiển thị trực tiếp trên màn hình đồng thời được lưu trữ vĩnh viễn tại mục <a href="{{ route('user.purchased') }}" class="text-gaming-neon hover:underline">"Kho Acc Đã Mua"</a> trong hồ sơ cá nhân của bạn.
                </div>
            </div>

            <!-- FAQ 2 -->
            <div class="bg-gaming-card border border-gaming-border rounded-xl overflow-hidden transition-all">
                <button @click="activeFaq = (activeFaq === 2 ? null : 2)" class="w-full text-left p-5 flex items-center justify-between focus:outline-none">
                    <span class="font-semibold text-white text-sm sm:text-base hover:text-gaming-neon transition-colors"><i class="fa-solid fa-circle-question mr-3 text-gaming-purple"></i>Tôi có thể nạp tiền vào ví bằng cách nào?</span>
                    <i class="fa-solid" :class="activeFaq === 2 ? 'fa-chevron-up text-gaming-neon' : 'fa-chevron-down text-gray-400'"></i>
                </button>
                <div x-show="activeFaq === 2" x-collapse x-transition class="px-5 pb-5 border-t border-gaming-border/50 pt-4 text-sm text-gray-400 leading-relaxed bg-gaming-dark/20">
                    Bạn có thể nạp tiền thông qua chuyển khoản ngân hàng tự động (quét mã VietQR nhận tiền sau 3 giây) hoặc chuyển khoản ATM/Internet Banking. Giao dịch được xử lý hoàn toàn miễn phí và cộng số dư ví ảo tức thì để bạn mua sắm tài khoản.
                </div>
            </div>

            <!-- FAQ 3 -->
            <div class="bg-gaming-card border border-gaming-border rounded-xl overflow-hidden transition-all">
                <button @click="activeFaq = (activeFaq === 3 ? null : 3)" class="w-full text-left p-5 flex items-center justify-between focus:outline-none">
                    <span class="font-semibold text-white text-sm sm:text-base hover:text-gaming-neon transition-colors"><i class="fa-solid fa-circle-question mr-3 text-gaming-purple"></i>Chính sách bảo hành tài khoản ra sao?</span>
                    <i class="fa-solid" :class="activeFaq === 3 ? 'fa-chevron-up text-gaming-neon' : 'fa-chevron-down text-gray-400'"></i>
                </button>
                <div x-show="activeFaq === 3" x-collapse x-transition class="px-5 pb-5 border-t border-gaming-border/50 pt-4 text-sm text-gray-400 leading-relaxed bg-gaming-dark/20">
                    Tất cả tài khoản được bán trên GameShop đều được kiểm duyệt chặt chẽ, sạch thông tin và hỗ trợ thay đổi email liên kết hoàn toàn. Shop cam kết bảo hành lỗi 1 đổi 1 hoặc hoàn tiền 100% trong trường hợp có lỗi phát sinh từ phía shop (lỗi sai mật khẩu, tài khoản bị tranh chấp trong thời gian bảo hành).
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
