@extends('layouts.app')

@section('title', 'Quản Lý Mã Giảm Giá - GameShop Admin')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <!-- Header title with direct create link button -->
    <div class="mb-8 border-b border-gaming-border/40 pb-5 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div class="text-left space-y-2">
            <h1 class="font-gaming font-black text-2xl tracking-wider text-white uppercase"><i class="fa-solid fa-ticket text-gaming-neon mr-2"></i>QUẢN LÝ <span class="bg-gradient-to-r from-gaming-purple to-gaming-pink bg-clip-text text-transparent">MÃ GIẢM GIÁ</span></h1>
            <p class="text-xs text-gray-400">Danh sách các mã khuyến mãi áp dụng giảm giá khi người dùng thanh toán giỏ hàng.</p>
        </div>
        
        <a href="{{ route('admin.coupons.create') }}" class="bg-gradient-to-r from-gaming-purple to-gaming-pink font-bold text-xs px-5 py-3 rounded-xl text-white hover:opacity-90 transition-all transform hover:-translate-y-0.5"><i class="fa-solid fa-circle-plus mr-1.5"></i>TẠO MÃ KHUYẾN MÃI</a>
    </div>

    <!-- Table Container -->
    <div class="bg-gaming-card border border-gaming-border p-6 rounded-2xl shadow-glass space-y-6">
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm text-left text-gray-400">
                <thead class="text-xs font-bold uppercase tracking-wider text-gray-500 border-b border-gaming-border/80">
                    <tr>
                        <th class="py-3.5 px-4">Mã số</th>
                        <th class="py-3.5 px-4">Mã Coupon</th>
                        <th class="py-3.5 px-4">Giá trị giảm</th>
                        <th class="py-3.5 px-4">Loại giảm giá</th>
                        <th class="py-3.5 px-4">Đơn tối thiểu</th>
                        <th class="py-3.5 px-4">Ngày hết hạn</th>
                        <th class="py-3.5 px-4">Kích hoạt</th>
                        <th class="py-3.5 px-4 text-right">Thao tác</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gaming-border/50 text-xs">
                    @forelse($coupons as $coupon)
                        <tr class="hover:bg-gaming-dark/20 transition-colors">
                            <td class="py-4 px-4 font-gaming text-gray-300">#{{ $coupon->id }}</td>
                            <td class="py-4 px-4 font-gaming text-white font-bold tracking-widest text-sm bg-gaming-dark/60 inline-block my-2 px-2.5 py-1 rounded border border-gaming-border">{{ $coupon->code }}</td>
                            <td class="py-4 px-4 text-white font-gaming font-semibold">
                                @if($coupon->discount_type === 'percent')
                                    {{ number_format($coupon->discount_amount, 0) }}%
                                @else
                                    {{ number_format($coupon->discount_amount, 0, ',', '.') }}đ
                                @endif
                            </td>
                            <td class="py-4 px-4 text-gray-300 font-medium">
                                {{ $coupon->discount_type === 'percent' ? 'Theo phần trăm' : 'Số tiền cố định' }}
                            </td>
                            <td class="py-4 px-4 font-gaming text-gray-400">{{ number_format($coupon->min_spend, 0, ',', '.') }}đ</td>
                            <td class="py-4 px-4 text-gray-400">
                                @if($coupon->expires_at)
                                    {{ \Carbon\Carbon::parse($coupon->expires_at)->format('d/m/Y') }}
                                @else
                                    <span class="text-xs text-gray-600">Vô thời hạn</span>
                                @endif
                            </td>
                            <td class="py-4 px-4">
                                <span class="py-0.5 px-2.5 rounded-full font-bold uppercase tracking-wider"
                                    :class="'{{ $coupon->active }}' ? 'bg-green-950/40 text-gaming-neon border border-gaming-neon/20' : 'bg-red-950/40 text-red-400 border border-red-500/20'">
                                    {{ $coupon->active ? 'Hoạt động' : 'Tạm tắt' }}
                                </span>
                            </td>
                            <td class="py-4 px-4 text-right">
                                <div class="inline-flex gap-2">
                                    <a href="{{ route('admin.coupons.edit', $coupon->id) }}" class="h-8 w-8 rounded-lg bg-gaming-dark hover:bg-gaming-purple border border-gaming-border hover:border-gaming-purple transition-all flex items-center justify-center text-gray-300 hover:text-white"><i class="fa-solid fa-pen-to-square text-xs"></i></a>
                                    
                                    <form action="{{ route('admin.coupons.destroy', $coupon->id) }}" method="POST" onsubmit="return confirm('Bạn chắc chắn muốn xóa mã giảm giá này?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="h-8 w-8 rounded-lg bg-gaming-dark hover:bg-red-500 border border-gaming-border hover:border-red-500 transition-all flex items-center justify-center text-gray-300 hover:text-white"><i class="fa-solid fa-trash-can text-xs"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="py-12 text-center text-gray-500">Chưa có mã giảm giá nào được tạo.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($coupons->hasPages())
            <div class="mt-6 flex justify-center">
                {{ $coupons->links('pagination::tailwind') }}
            </div>
        @endif
    </div>
</div>
@endsection
