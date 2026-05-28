@extends('layouts.app')

@section('title', 'Lịch Sử Giao Dịch - GameShop')

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
                <a href="{{ route('user.transactions') }}" class="flex items-center px-4 py-2.5 rounded-xl hover:text-white transition-all bg-gaming-purple text-white"><i class="fa-solid fa-history mr-3 text-base"></i>Lịch sử ví ảo</a>
                <a href="{{ route('user.purchased') }}" class="flex items-center px-4 py-2.5 rounded-xl hover:text-white hover:bg-gaming-dark transition-all"><i class="fa-solid fa-key mr-3 text-base"></i>Kho Acc Đã Mua</a>
                <a href="{{ route('user.wishlist') }}" class="flex items-center px-4 py-2.5 rounded-xl hover:text-white hover:bg-gaming-dark transition-all"><i class="fa-solid fa-heart mr-3 text-base text-gaming-pink"></i>Acc đã lưu</a>
            </nav>
        </div>

        <!-- Transactions Table (col-span-9) -->
        <div class="lg:col-span-9 bg-gaming-card border border-gaming-border p-6 rounded-2xl shadow-glass space-y-6">
            <h2 class="font-display font-bold text-xl text-white border-b border-gaming-border pb-4 flex items-center justify-between">
                <span>Lịch Sử Giao Dịch Ví</span>
                <span class="text-xs bg-gaming-dark border border-gaming-border text-gaming-neon py-1 px-3 rounded-full font-gaming">Số dư: {{ number_format(Auth::user()->balance, 0, ',', '.') }}đ</span>
            </h2>

            <div class="overflow-x-auto">
                <table class="min-w-full text-sm text-left text-gray-400">
                    <thead class="text-xs font-bold uppercase tracking-wider text-gray-500 border-b border-gaming-border/80">
                        <tr>
                            <th class="py-3.5 px-4">Mã GD</th>
                            <th class="py-3.5 px-4">Số Tiền</th>
                            <th class="py-3.5 px-4">Phân Loại</th>
                            <th class="py-3.5 px-4">Chi Tiết / Nội Dung</th>
                            <th class="py-3.5 px-4">Thời Gian</th>
                            <th class="py-3.5 px-4">Trạng Thái</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gaming-border/50">
                        @forelse($transactions as $t)
                            <tr class="hover:bg-gaming-dark/20 transition-colors">
                                <td class="py-4 px-4 font-gaming text-gray-300">#{{ $t->id }}</td>
                                <td class="py-4 px-4 font-gaming font-bold" 
                                    :class="'{{ $t->type }}' === 'deposit' ? 'text-gaming-neon' : 'text-gaming-pink'">
                                    {{ $t->type === 'deposit' ? '+' : '-' }}{{ number_format($t->amount, 0, ',', '.') }}đ
                                </td>
                                <td class="py-4 px-4 font-semibold text-xs">
                                    <span class="py-1 px-2.5 rounded-full"
                                        :class="{
                                            'bg-green-950/40 text-gaming-neon border border-gaming-neon/20': '{{ $t->type }}' === 'deposit',
                                            'bg-pink-950/40 text-gaming-pink border border-gaming-pink/20': '{{ $t->type }}' === 'purchase',
                                            'bg-gaming-dark text-gaming-purple border border-gaming-purple/20': '{{ $t->type }}' === 'refund'
                                        }">
                                        {{ $t->type === 'deposit' ? 'Nạp tiền' : ($t->type === 'purchase' ? 'Mua hàng' : 'Hoàn tiền') }}
                                    </span>
                                </td>
                                <td class="py-4 px-4 text-xs text-gray-300 leading-relaxed">{{ $t->description }}</td>
                                <td class="py-4 px-4 text-xs">{{ $t->created_at->format('H:i d/m/Y') }}</td>
                                <td class="py-4 px-4">
                                    <span class="inline-flex items-center text-xs font-bold text-gaming-neon"><i class="fa-solid fa-circle-check mr-1.5 text-2xs"></i>Thành công</span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-12 text-center text-gray-500">
                                    Không có giao dịch nào được ghi nhận.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($transactions->hasPages())
                <div class="mt-6 flex justify-center">
                    {{ $transactions->links('pagination::tailwind') }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
