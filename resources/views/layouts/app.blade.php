<!DOCTYPE html>
<html lang="vi" class="dark h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'GameShop - Shop Mua Bán Account Game Chuyên Nghiệp')</title>
    
    <!-- Meta SEO -->
    <meta name="description" content="Shop mua bán account game uy tín, giá rẻ. Đầy đủ các thể loại game League of Legends, Valorant, Free Fire, Genshin Impact với giá ưu đãi cực sốc.">
    <meta name="keywords" content="shop acc game, mua acc game, shop acc lol, shop acc valorant, mua acc free fire">
    
    <!-- Google Fonts: Inter & Orbitron for Gaming Vibe -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Orbitron:wght@500;700;900&family=Outfit:wght@400;600;800&display=swap" rel="stylesheet">
    
    <!-- Tailwind Play CDN with Custom Gaming Config -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        gaming: {
                            dark: '#080511',       // Deep rich purple-black background
                            card: '#120e23',       // Obsidian dark card background
                            border: '#231c3f',     // Muted purple border
                            purple: '#7c3aed',     // Bright neon violet
                            pink: '#ec4899',       // Cyberpunk pink
                            neon: '#00f5a0',       // Cyberpunk bright green-cyan
                            blue: '#3b82f6'
                        }
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        display: ['Outfit', 'sans-serif'],
                        gaming: ['Orbitron', 'sans-serif']
                    },
                    boxShadow: {
                        'neon-purple': '0 0 15px rgba(124, 58, 237, 0.4)',
                        'neon-green': '0 0 15px rgba(0, 245, 160, 0.4)',
                        'neon-pink': '0 0 15px rgba(236, 72, 153, 0.4)',
                        'glass': '0 8px 32px 0 rgba(12, 6, 28, 0.37)'
                    }
                }
            }
        }
    </script>
    
    <!-- FontAwesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Alpine.js for Interactive Logic & Animations -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <style>
        body {
            background-color: #080511;
            font-family: 'Inter', sans-serif;
            color: #e2e8f0;
            overflow-x: hidden;
        }
        
        /* Custom Glowing Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #080511;
        }
        ::-webkit-scrollbar-thumb {
            background: #231c3f;
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #7c3aed;
            box-shadow: 0 0 8px #7c3aed;
        }
        
        .glow-text-purple {
            text-shadow: 0 0 10px rgba(124, 58, 237, 0.6);
        }
        .glow-text-neon {
            text-shadow: 0 0 10px rgba(0, 245, 160, 0.6);
        }
    </style>
</head>
<body class="flex flex-col min-h-screen relative" x-data="{ 
    cartCount: {{ session()->has('cart') ? count(session('cart')) : 0 }},
    isMobileMenuOpen: false
}">

    <!-- Background Decorative Glowing Orbs -->
    <div class="absolute top-[-10%] left-[-10%] w-[500px] h-[500px] rounded-full bg-gaming-purple/20 blur-[120px] pointer-events-none z-0"></div>
    <div class="absolute bottom-[20%] right-[-10%] w-[600px] h-[600px] rounded-full bg-gaming-pink/10 blur-[150px] pointer-events-none z-0"></div>
    <div class="absolute top-[40%] left-[45%] w-[400px] h-[400px] rounded-full bg-gaming-neon/10 blur-[130px] pointer-events-none z-0"></div>

    <!-- Header (Sticky & Glassmorphic) -->
    <header class="sticky top-0 z-50 backdrop-blur-lg bg-gaming-dark/70 border-b border-gaming-border/80 transition-all duration-300 shadow-glass">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                <!-- Logo -->
                <div class="flex-shrink-0">
                    <a href="{{ route('home') }}" class="flex items-center space-x-2">
                        <i class="fa-solid fa-gamepad text-gaming-neon text-3xl animate-pulse"></i>
                        <span class="font-gaming font-black text-2xl tracking-widest bg-gradient-to-r from-gaming-purple via-gaming-pink to-gaming-neon bg-clip-text text-transparent">GAMESHOP</span>
                    </a>
                </div>

                <!-- Navigation Links (Desktop) -->
                <nav class="hidden md:flex space-x-8">
                    <a href="{{ route('home') }}" class="text-sm font-semibold tracking-wide hover:text-gaming-neon transition-colors {{ request()->routeIs('home') ? 'text-gaming-neon border-b-2 border-gaming-neon pb-1' : 'text-gray-300' }}">Trang Chủ</a>
                    <a href="{{ route('accounts.index') }}" class="text-sm font-semibold tracking-wide hover:text-gaming-neon transition-colors {{ request()->routeIs('accounts.index') || request()->routeIs('accounts.show') ? 'text-gaming-neon border-b-2 border-gaming-neon pb-1' : 'text-gray-300' }}">Mua Account</a>
                    <a href="{{ route('home') }}#thongke" class="text-sm font-semibold tracking-wide hover:text-gaming-neon transition-colors text-gray-300">Thống Kê</a>
                    <a href="{{ route('home') }}#footer" class="text-sm font-semibold tracking-wide hover:text-gaming-neon transition-colors text-gray-300">Hỗ Trợ</a>
                </nav>

                <!-- Header Actions (Cart, User, Admin) -->
                <div class="hidden md:flex items-center space-x-4">
                    <!-- Wishlist Link -->
                    @auth
                    <a href="{{ route('user.wishlist') }}" class="relative p-2 text-gray-300 hover:text-gaming-pink transition-colors">
                        <i class="fa-regular fa-heart text-xl"></i>
                    </a>
                    @endauth

                    <!-- Cart Widget -->
                    <a href="{{ route('cart.index') }}" class="relative p-2 text-gray-300 hover:text-gaming-neon transition-colors">
                        <i class="fa-solid fa-basket-shopping text-xl"></i>
                        <span class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-gaming-dark bg-gaming-neon rounded-full" x-text="cartCount"></span>
                    </a>

                    <!-- User Panel -->
                    @auth
                        <div class="h-8 w-px bg-gaming-border"></div>
                        <div class="flex items-center space-x-3" x-data="{ isUserMenuOpen: false }">
                            <!-- Wallet Balance Badge -->
                            <a href="{{ route('user.deposit') }}" class="flex items-center space-x-1.5 bg-gaming-card hover:bg-gaming-border/80 border border-gaming-border/80 rounded-full py-1 px-3 text-xs text-gaming-neon font-bold transition-all shadow-neon-green/20">
                                <i class="fa-solid fa-wallet"></i>
                                <span>{{ number_format(Auth::user()->balance, 0, ',', '.') }}đ</span>
                            </a>

                            <!-- Profile Menu -->
                            <div class="relative">
                                <button @click="isUserMenuOpen = !isUserMenuOpen" @click.away="isUserMenuOpen = false" class="flex items-center space-x-2 focus:outline-none">
                                    <img class="h-9 w-9 rounded-full border-2 border-gaming-purple object-cover" src="{{ Auth::user()->avatar ?? 'https://api.dicebear.com/7.x/bottts/svg?seed=' . Auth::user()->email }}" alt="Avatar">
                                    <span class="text-sm font-semibold text-gray-300 hover:text-gaming-purple transition-colors">{{ Auth::user()->name }}</span>
                                    <i class="fa-solid fa-chevron-down text-xs text-gray-400"></i>
                                </button>

                                <!-- Dropdown -->
                                <div x-show="isUserMenuOpen" x-transition class="absolute right-0 mt-3 w-48 rounded-md bg-gaming-card border border-gaming-border shadow-2xl py-1 text-gray-200 z-50">
                                    @if(Auth::user()->isAdmin())
                                        <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 text-sm hover:bg-gaming-purple/20 text-gaming-neon font-semibold"><i class="fa-solid fa-user-shield mr-2"></i>Admin Dashboard</a>
                                    @endif
                                    <a href="{{ route('user.profile') }}" class="block px-4 py-2 text-sm hover:bg-gaming-purple/20"><i class="fa-solid fa-user mr-2"></i>Hồ sơ cá nhân</a>
                                    <a href="{{ route('user.transactions') }}" class="block px-4 py-2 text-sm hover:bg-gaming-purple/20"><i class="fa-solid fa-history mr-2"></i>Lịch sử ví</a>
                                    <a href="{{ route('user.purchased') }}" class="block px-4 py-2 text-sm hover:bg-gaming-purple/20"><i class="fa-solid fa-key mr-2"></i>Kho Acc Đã Mua</a>
                                    <hr class="border-gaming-border my-1">
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="w-full text-left px-4 py-2 text-sm hover:bg-red-500/20 text-red-400"><i class="fa-solid fa-right-from-bracket mr-2"></i>Đăng xuất</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="text-sm font-bold text-gray-300 hover:text-white transition-colors">Đăng nhập</a>
                        <a href="{{ route('register') }}" class="bg-gradient-to-r from-gaming-purple to-gaming-pink text-sm font-bold px-5 py-2.5 rounded-lg text-white hover:opacity-90 shadow-neon-purple/30 transition-all transform hover:-translate-y-0.5">Đăng Ký</a>
                    @endauth
                </div>

                <!-- Mobile Menu Button -->
                <div class="md:hidden flex items-center space-x-4">
                    <a href="{{ route('cart.index') }}" class="relative p-2 text-gray-300 hover:text-gaming-neon">
                        <i class="fa-solid fa-basket-shopping text-xl"></i>
                        <span class="absolute top-0 right-0 inline-flex items-center justify-center px-1.5 py-0.5 text-2xs font-bold leading-none text-gaming-dark bg-gaming-neon rounded-full" x-text="cartCount"></span>
                    </a>
                    
                    <button @click="isMobileMenuOpen = !isMobileMenuOpen" class="text-gray-300 focus:outline-none">
                        <i class="fa-solid fa-bars text-2xl" x-show="!isMobileMenuOpen"></i>
                        <i class="fa-solid fa-xmark text-2xl" x-show="isMobileMenuOpen" x-cloak></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Navigation Menu -->
        <div x-show="isMobileMenuOpen" x-transition class="md:hidden bg-gaming-dark border-b border-gaming-border px-4 pt-2 pb-4 space-y-2 z-50 relative">
            <a href="{{ route('home') }}" class="block px-3 py-2 rounded-md text-base font-semibold hover:bg-gaming-card hover:text-gaming-neon transition-all">Trang Chủ</a>
            <a href="{{ route('accounts.index') }}" class="block px-3 py-2 rounded-md text-base font-semibold hover:bg-gaming-card hover:text-gaming-neon transition-all">Mua Account</a>
            <a href="{{ route('home') }}#thongke" @click="isMobileMenuOpen = false" class="block px-3 py-2 rounded-md text-base font-semibold hover:bg-gaming-card text-gray-300">Thống Kê</a>
            <a href="{{ route('home') }}#footer" @click="isMobileMenuOpen = false" class="block px-3 py-2 rounded-md text-base font-semibold hover:bg-gaming-card text-gray-300">Hỗ Trợ</a>
            
            <hr class="border-gaming-border my-2">
            
            @auth
                <div class="flex items-center justify-between px-3 py-2">
                    <span class="text-xs text-gray-400 font-bold uppercase tracking-wider">Tài khoản</span>
                    <a href="{{ route('user.deposit') }}" class="text-xs text-gaming-neon font-bold bg-gaming-card py-1 px-3 border border-gaming-border rounded-full"><i class="fa-solid fa-wallet mr-1"></i>{{ number_format(Auth::user()->balance, 0, ',', '.') }}đ</a>
                </div>
                @if(Auth::user()->isAdmin())
                    <a href="{{ route('admin.dashboard') }}" class="block px-3 py-2 rounded-md text-base font-semibold hover:bg-gaming-card text-gaming-neon"><i class="fa-solid fa-user-shield mr-2"></i>Admin Dashboard</a>
                @endif
                <a href="{{ route('user.profile') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-300 hover:bg-gaming-card"><i class="fa-solid fa-user mr-2"></i>Hồ sơ</a>
                <a href="{{ route('user.purchased') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-300 hover:bg-gaming-card"><i class="fa-solid fa-key mr-2"></i>Kho Acc Đã Mua</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full text-left px-3 py-2 rounded-md text-base font-medium text-red-400 hover:bg-gaming-card"><i class="fa-solid fa-right-from-bracket mr-2"></i>Đăng xuất</button>
                </form>
            @else
                <div class="grid grid-cols-2 gap-2 pt-2">
                    <a href="{{ route('login') }}" class="text-center py-2.5 rounded-lg border border-gaming-border text-sm font-semibold text-gray-300 hover:text-white">Đăng nhập</a>
                    <a href="{{ route('register') }}" class="text-center py-2.5 rounded-lg bg-gradient-to-r from-gaming-purple to-gaming-pink text-sm font-semibold text-white">Đăng ký</a>
                </div>
            @endauth
        </div>
    </header>

    <!-- Main Content Area -->
    <main class="flex-grow z-10 relative">
        @yield('content')
    </main>

    <!-- Footer Component -->
    <footer id="footer" class="bg-gaming-dark/95 border-t border-gaming-border/80 pt-16 pb-8 z-10 relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <!-- Branding column -->
                <div class="space-y-4 col-span-1 md:col-span-1">
                    <div class="flex items-center space-x-2">
                        <i class="fa-solid fa-gamepad text-gaming-neon text-3xl"></i>
                        <span class="font-gaming font-black text-2xl tracking-widest bg-gradient-to-r from-gaming-purple via-gaming-pink to-gaming-neon bg-clip-text text-transparent">GAMESHOP</span>
                    </div>
                    <p class="text-sm text-gray-400 leading-relaxed">
                        Hệ thống mua bán account game chuyên nghiệp, uy tín hàng đầu Việt Nam. Tự động hóa giao dịch 100%, bảo mật tuyệt đối thông tin khách hàng.
                    </p>
                    <div class="flex space-x-4 pt-2">
                        <a href="#" class="h-10 w-10 bg-gaming-card hover:bg-gaming-purple border border-gaming-border hover:border-gaming-purple rounded-lg flex items-center justify-center text-gray-400 hover:text-white transition-all transform hover:-translate-y-1"><i class="fa-brands fa-facebook-f text-lg"></i></a>
                        <a href="#" class="h-10 w-10 bg-gaming-card hover:bg-gaming-pink border border-gaming-border hover:border-gaming-pink rounded-lg flex items-center justify-center text-gray-400 hover:text-white transition-all transform hover:-translate-y-1"><i class="fa-brands fa-discord text-lg"></i></a>
                        <a href="#" class="h-10 w-10 bg-gaming-card hover:bg-gaming-neon border border-gaming-border hover:border-gaming-neon rounded-lg flex items-center justify-center text-gray-400 hover:text-gaming-dark transition-all transform hover:-translate-y-1"><i class="fa-brands fa-youtube text-lg"></i></a>
                    </div>
                </div>

                <!-- Game list column -->
                <div class="space-y-4">
                    <h3 class="text-sm font-semibold uppercase tracking-wider text-gaming-neon">Game Hot</h3>
                    <ul class="space-y-2.5 text-sm text-gray-400">
                        <li><a href="{{ route('accounts.index') }}?game=lien-minh-huyen-thoai" class="hover:text-gaming-purple transition-colors"><i class="fa-solid fa-chevron-right text-xs mr-2 text-gaming-purple/50"></i>Liên Minh Huyền Thoại</a></li>
                        <li><a href="{{ route('accounts.index') }}?game=valorant" class="hover:text-gaming-purple transition-colors"><i class="fa-solid fa-chevron-right text-xs mr-2 text-gaming-purple/50"></i>Valorant</a></li>
                        <li><a href="{{ route('accounts.index') }}?game=free-fire" class="hover:text-gaming-purple transition-colors"><i class="fa-solid fa-chevron-right text-xs mr-2 text-gaming-purple/50"></i>Free Fire</a></li>
                        <li><a href="{{ route('accounts.index') }}?game=genshin-impact" class="hover:text-gaming-purple transition-colors"><i class="fa-solid fa-chevron-right text-xs mr-2 text-gaming-purple/50"></i>Genshin Impact</a></li>
                    </ul>
                </div>

                <!-- Policies column -->
                <div class="space-y-4">
                    <h3 class="text-sm font-semibold uppercase tracking-wider text-gaming-purple">Điều Khoản</h3>
                    <ul class="space-y-2.5 text-sm text-gray-400">
                        <li><a href="#" class="hover:text-gaming-purple transition-colors"><i class="fa-solid fa-chevron-right text-xs mr-2 text-gaming-purple/50"></i>Điều khoản sử dụng</a></li>
                        <li><a href="#" class="hover:text-gaming-purple transition-colors"><i class="fa-solid fa-chevron-right text-xs mr-2 text-gaming-purple/50"></i>Chính sách bảo mật</a></li>
                        <li><a href="#" class="hover:text-gaming-purple transition-colors"><i class="fa-solid fa-chevron-right text-xs mr-2 text-gaming-purple/50"></i>Cơ chế bảo hành 100%</a></li>
                        <li><a href="#" class="hover:text-gaming-purple transition-colors"><i class="fa-solid fa-chevron-right text-xs mr-2 text-gaming-purple/50"></i>Liên hệ hỗ trợ</a></li>
                    </ul>
                </div>

                <!-- Info/Contact column -->
                <div class="space-y-4">
                    <h3 class="text-sm font-semibold uppercase tracking-wider text-gaming-pink">Thông Tin Hỗ Trợ</h3>
                    <ul class="space-y-3 text-sm text-gray-400">
                        <li class="flex items-start"><i class="fa-solid fa-headset text-gaming-pink mt-1 mr-3 text-base"></i><span>Hotline: 1900 1234 (8h - 22h)</span></li>
                        <li class="flex items-start"><i class="fa-solid fa-envelope text-gaming-pink mt-1 mr-3 text-base"></i><span>Email: hotro@gameshop.com</span></li>
                        <li class="flex items-start"><i class="fa-solid fa-shield-halved text-gaming-pink mt-1 mr-3 text-base"></i><span>Giao dịch bảo mật qua cổng mã hóa SSL tự động</span></li>
                    </ul>
                </div>
            </div>

            <!-- Credits copyright -->
            <div class="mt-12 pt-8 border-t border-gaming-border/60 text-center text-xs text-gray-500 flex flex-col md:flex-row items-center justify-between">
                <span>&copy; {{ date('Y') }} GameShop. All rights reserved. Dev with ❤️ by Google DeepMind team.</span>
                <span class="flex items-center mt-3 md:mt-0 space-x-4">
                    <img src="https://img.vietqr.io/image/vietinbank-970415-logo.png" class="h-6 opacity-30 hover:opacity-60 transition-opacity" alt="Bank logo">
                    <img src="https://img.vietqr.io/image/mbbank-970422-logo.png" class="h-6 opacity-30 hover:opacity-60 transition-opacity" alt="Bank logo">
                </span>
            </div>
        </div>
    </footer>

    <!-- Toast Notifications via Alpine.js -->
    <div x-data="toastManager()" 
         @toast-message.window="addToast($event.detail)" 
         class="fixed bottom-5 right-5 z-50 flex flex-col gap-3 max-w-sm w-full">
        <template x-for="toast in toasts" :key="toast.id">
            <div x-show="toast.visible" 
                 x-transition:enter="transition ease-out duration-300 transform" 
                 x-transition:enter-start="translate-y-2 opacity-0 scale-95" 
                 x-transition:enter-end="translate-y-0 opacity-100 scale-100" 
                 x-transition:leave="transition ease-in duration-200 transform" 
                 x-transition:leave-start="translate-y-0 opacity-100 scale-100" 
                 x-transition:leave-end="translate-y-2 opacity-0 scale-95" 
                 :class="{
                     'bg-green-950/90 border border-gaming-neon/50 text-gaming-neon shadow-neon-green/10': toast.type === 'success',
                     'bg-red-950/90 border border-gaming-pink/50 text-red-400 shadow-neon-pink/10': toast.type === 'error',
                     'bg-gaming-card/90 border border-gaming-purple/50 text-gaming-purple shadow-neon-purple/10': toast.type === 'info'
                 }"
                 class="p-4 rounded-xl flex items-center justify-between backdrop-blur-md shadow-2xl">
                
                <div class="flex items-center space-x-3">
                    <i :class="{
                        'fa-solid fa-circle-check text-xl': toast.type === 'success',
                        'fa-solid fa-triangle-exclamation text-xl': toast.type === 'error',
                        'fa-solid fa-circle-info text-xl': toast.type === 'info'
                    }"></i>
                    <p class="text-sm font-semibold tracking-wide" x-text="toast.message"></p>
                </div>

                <button @click="removeToast(toast.id)" class="text-gray-400 hover:text-white focus:outline-none pl-3">
                    <i class="fa-solid fa-xmark text-sm"></i>
                </button>
            </div>
        </template>
    </div>

    <!-- Toast Logic Script -->
    <script>
        function toastManager() {
            return {
                toasts: [],
                addToast(detail) {
                    const id = Date.now();
                    this.toasts.push({
                        id: id,
                        message: detail.message,
                        type: detail.type || 'info',
                        visible: true
                    });
                    
                    // Dispatch success toast or error automatically
                    setTimeout(() => {
                        this.removeToast(id);
                    }, 4000);
                },
                removeToast(id) {
                    const index = this.toasts.findIndex(t => t.id === id);
                    if (index !== -1) {
                        this.toasts[index].visible = false;
                        setTimeout(() => {
                            this.toasts = this.toasts.filter(t => t.id !== id);
                        }, 300);
                    }
                }
            }
        }
        
        // Helper to trigger toast easily from anywhere (Alpine.js or normal JS)
        window.triggerToast = function(message, type = 'success') {
            window.dispatchEvent(new CustomEvent('toast-message', {
                detail: { message, type }
            }));
        };
        
        // Trigger Toast for session flash success / errors
        document.addEventListener('DOMContentLoaded', () => {
            @if(session('success'))
                setTimeout(() => triggerToast("{{ session('success') }}", 'success'), 300);
            @endif
            @if(session('error'))
                setTimeout(() => triggerToast("{{ session('error') }}", 'error'), 300);
            @endif
            @if($errors->any())
                setTimeout(() => triggerToast("{{ $errors->first() }}", 'error'), 300);
            @endif
        });
    </script>
</body>
</html>
