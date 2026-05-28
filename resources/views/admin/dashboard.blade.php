@extends('layouts.app')

@section('title', 'Admin Dashboard - GameShop Management')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <!-- Top admin title bar -->
    <div class="mb-10 border-b border-gaming-border/40 pb-5 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div class="text-left space-y-2">
            <h1 class="font-gaming font-black text-2xl tracking-wider text-white uppercase"><i class="fa-solid fa-user-shield text-gaming-purple mr-2"></i>BÀN LÀM VIỆC <span class="bg-gradient-to-r from-gaming-purple to-gaming-pink bg-clip-text text-transparent">ADMIN</span></h1>
            <p class="text-xs text-gray-400">Trang điều khiển quản trị hệ thống, quản lý doanh thu, tài khoản game và thành viên.</p>
        </div>
        
        <!-- Admin quick links bar -->
        <div class="flex flex-wrap gap-2 text-xs font-bold font-gaming uppercase tracking-wider">
            <a href="{{ route('admin.games.index') }}" class="py-2 px-4 bg-gaming-card border border-gaming-border hover:border-gaming-purple text-gray-300 hover:text-white rounded-xl transition-all"><i class="fa-solid fa-folder mr-1.5 text-gaming-purple"></i>Danh mục game</a>
            <a href="{{ route('admin.accounts.index') }}" class="py-2 px-4 bg-gaming-card border border-gaming-border hover:border-gaming-purple text-gray-300 hover:text-white rounded-xl transition-all"><i class="fa-solid fa-gamepad mr-1.5 text-gaming-neon"></i>Danh sách acc</a>
            <a href="{{ route('admin.users.index') }}" class="py-2 px-4 bg-gaming-card border border-gaming-border hover:border-gaming-purple text-gray-300 hover:text-white rounded-xl transition-all"><i class="fa-solid fa-users mr-1.5 text-gaming-blue"></i>Thành viên</a>
            <a href="{{ route('admin.orders.index') }}" class="py-2 px-4 bg-gaming-card border border-gaming-border hover:border-gaming-purple text-gray-300 hover:text-white rounded-xl transition-all"><i class="fa-solid fa-receipt mr-1.5 text-gaming-pink"></i>Đơn hàng</a>
            <a href="{{ route('admin.coupons.index') }}" class="py-2 px-4 bg-gaming-card border border-gaming-border hover:border-gaming-purple text-gray-300 hover:text-white rounded-xl transition-all"><i class="fa-solid fa-ticket mr-1.5 text-yellow-400"></i>Giảm giá</a>
        </div>
    </div>

    <!-- 4 Stats Cards Grid -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
        <!-- Revenue Card -->
        <div class="bg-gaming-card border border-gaming-border p-5 rounded-2xl shadow-glass flex items-center justify-between group overflow-hidden relative">
            <div class="absolute -right-4 -bottom-4 w-16 h-16 rounded-full bg-gaming-neon/10 blur-xl group-hover:bg-gaming-neon/20 transition-all duration-300"></div>
            <div>
                <span class="block text-4xs text-gray-500 uppercase tracking-widest font-semibold">TỔNG DOANH THU</span>
                <span class="text-xl sm:text-2xl font-black text-gaming-neon glow-text-neon font-gaming mt-1 block">{{ number_format($stats['revenue'], 0, ',', '.') }}đ</span>
            </div>
            <div class="h-12 w-12 bg-gaming-neon/20 border border-gaming-neon/30 text-gaming-neon flex items-center justify-center text-xl rounded-xl shadow-neon-green/10">
                <i class="fa-solid fa-money-bill-trend-up"></i>
            </div>
        </div>

        <!-- Accounts Sold Card -->
        <div class="bg-gaming-card border border-gaming-border p-5 rounded-2xl shadow-glass flex items-center justify-between group overflow-hidden relative">
            <div class="absolute -right-4 -bottom-4 w-16 h-16 rounded-full bg-gaming-pink/10 blur-xl group-hover:bg-gaming-pink/20 transition-all duration-300"></div>
            <div>
                <span class="block text-4xs text-gray-500 uppercase tracking-widest font-semibold">TÀI KHOẢN ĐÃ BÁN</span>
                <span class="text-xl sm:text-2xl font-black text-gaming-pink glow-text-pink font-gaming mt-1 block">{{ $stats['accounts_sold'] }} Acc</span>
            </div>
            <div class="h-12 w-12 bg-gaming-pink/20 border border-gaming-pink/30 text-gaming-pink flex items-center justify-center text-xl rounded-xl shadow-neon-pink/10">
                <i class="fa-solid fa-handshake-check"></i>
            </div>
        </div>

        <!-- Available Accounts Card -->
        <div class="bg-gaming-card border border-gaming-border p-5 rounded-2xl shadow-glass flex items-center justify-between group overflow-hidden relative">
            <div class="absolute -right-4 -bottom-4 w-16 h-16 rounded-full bg-gaming-purple/10 blur-xl group-hover:bg-gaming-purple/20 transition-all duration-300"></div>
            <div>
                <span class="block text-4xs text-gray-500 uppercase tracking-widest font-semibold">ACC ĐANG TREO BÁN</span>
                <span class="text-xl sm:text-2xl font-black text-gaming-purple glow-text-purple font-gaming mt-1 block">{{ $stats['accounts_available'] }} Acc</span>
            </div>
            <div class="h-12 w-12 bg-gaming-purple/20 border border-gaming-purple/30 text-gaming-purple flex items-center justify-center text-xl rounded-xl shadow-neon-purple/10">
                <i class="fa-solid fa-hourglass-half"></i>
            </div>
        </div>

        <!-- Total Users Card -->
        <div class="bg-gaming-card border border-gaming-border p-5 rounded-2xl shadow-glass flex items-center justify-between group overflow-hidden relative">
            <div class="absolute -right-4 -bottom-4 w-16 h-16 rounded-full bg-gaming-blue/10 blur-xl group-hover:bg-gaming-blue/20 transition-all duration-300"></div>
            <div>
                <span class="block text-4xs text-gray-500 uppercase tracking-widest font-semibold">TỔNG THÀNH VIÊN</span>
                <span class="text-xl sm:text-2xl font-black text-gaming-blue font-gaming mt-1 block">{{ $stats['total_users'] }} User</span>
            </div>
            <div class="h-12 w-12 bg-gaming-blue/20 border border-gaming-blue/30 text-gaming-blue flex items-center justify-center text-xl rounded-xl shadow-glass">
                <i class="fa-solid fa-users"></i>
            </div>
        </div>
    </div>

    <!-- Chart & Tables Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
        
        <!-- Sales Chart Box (col-span-8) -->
        <div class="lg:col-span-8 bg-gaming-card border border-gaming-border p-6 rounded-2xl shadow-glass space-y-4">
            <h2 class="font-display font-bold text-base text-white flex items-center">
                <i class="fa-solid fa-chart-area text-gaming-neon mr-2"></i>Biểu Đồ Thống Kê Doanh Thu Sáu Tháng
            </h2>
            <div class="h-80 relative flex items-center justify-center w-full bg-gaming-dark/30 p-2 border border-gaming-border rounded-xl">
                <canvas id="revenueChart" class="w-full h-full"></canvas>
            </div>
        </div>

        <!-- Latest Orders Box (col-span-4) -->
        <div class="lg:col-span-4 bg-gaming-card border border-gaming-border p-6 rounded-2xl shadow-glass space-y-4">
            <h2 class="font-display font-bold text-base text-white flex items-center">
                <i class="fa-solid fa-clock-rotate-left text-gaming-pink mr-2"></i>Đơn Hàng Gần Đây
            </h2>
            
            <div class="space-y-3.5 max-h-[320px] overflow-y-auto pr-1">
                @forelse($latestOrders as $o)
                    <div class="bg-gaming-dark/40 border border-gaming-border p-3.5 rounded-xl flex items-center justify-between text-xs gap-3">
                        <div class="space-y-1">
                            <span class="block font-bold text-white">Đơn hàng #{{ $o->id }}</span>
                            <span class="block text-4xs text-gray-500">{{ $o->user->name }} • {{ $o->created_at->format('d/m H:i') }}</span>
                        </div>
                        <div class="text-right">
                            <span class="block font-bold text-gaming-neon font-gaming">{{ number_format($o->final_amount, 0, ',', '.') }}đ</span>
                            <span class="block text-4xs text-gaming-neon font-bold uppercase tracking-wider">Thành công</span>
                        </div>
                    </div>
                @empty
                    <p class="text-xs text-gray-500 text-center py-6">Chưa có giao dịch đơn hàng nào được thực hiện.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>

<!-- Chart.js dynamic initialization script -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const ctx = document.getElementById('revenueChart').getContext('2d');
        
        // Custom Gradient
        const neonGradient = ctx.createLinearGradient(0, 0, 0, 400);
        neonGradient.addColorStop(0, 'rgba(0, 245, 160, 0.4)');
        neonGradient.addColorStop(1, 'rgba(0, 245, 160, 0.0)');
        
        const labels = {!! json_encode($chartData['labels']) !!};
        const data = {!! json_encode($chartData['data']) !!};
        
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Doanh thu (đ)',
                    data: data,
                    backgroundColor: neonGradient,
                    borderColor: '#00f5a0',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: '#00f5a0',
                    pointHoverRadius: 8
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    x: {
                        grid: {
                            color: '#231c3f',
                            borderColor: '#231c3f'
                        },
                        ticks: {
                            color: '#94a3b8',
                            font: {
                                size: 10
                            }
                        }
                    },
                    y: {
                        grid: {
                            color: '#231c3f',
                            borderColor: '#231c3f'
                        },
                        ticks: {
                            color: '#94a3b8',
                            font: {
                                size: 10
                            },
                            callback: function(value) {
                                return (value / 1000000) + ' Tr';
                            }
                        }
                    }
                }
            }
        });
    });
</script>
@endsection
