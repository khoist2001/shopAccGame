@extends('layouts.app')

@section('title', 'Quản Lý Đơn Hàng - GameShop Admin')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <!-- Header title -->
    <div class="mb-8 border-b border-gaming-border/40 pb-5 text-left space-y-2">
        <h1 class="font-gaming font-black text-2xl tracking-wider text-white uppercase"><i class="fa-solid fa-receipt text-gaming-neon mr-2"></i>QUẢN LÝ <span class="bg-gradient-to-r from-gaming-purple to-gaming-pink bg-clip-text text-transparent">ĐƠN HÀNG</span></h1>
        <p class="text-xs text-gray-400">Danh sách tất cả các đơn mua tài khoản game trên hệ thống.</p>
    </div>

    <!-- Table Container -->
    <div class="bg-gaming-card border border-gaming-border p-6 rounded-2xl shadow-glass space-y-6">
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm text-left text-gray-400">
                <thead class="text-xs font-bold uppercase tracking-wider text-gray-500 border-b border-gaming-border/80">
                    <tr>
                        <th class="py-3.5 px-4">Mã Đơn</th>
                        <th class="py-3.5 px-4">Khách hàng</th>
                        <th class="py-3.5 px-4">Giá gốc</th>
                        <th class="py-3.5 px-4">Giảm giá</th>
                        <th class="py-3.5 px-4">Thực thu</th>
                        <th class="py-3.5 px-4">Trạng thái</th>
                        <th class="py-3.5 px-4">Ngày mua</th>
                        <th class="py-3.5 px-4 text-right">Thao tác</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gaming-border/50 text-xs">
                    @forelse($orders as $order)
                        <tr class="hover:bg-gaming-dark/20 transition-colors">
                            <td class="py-4 px-4 font-gaming text-gray-300">#{{ $order->id }}</td>
                            <td class="py-4 px-4">
                                <div class="flex items-center space-x-2">
                                    <span class="font-bold text-white">{{ $order->user->name ?? 'Người dùng đã bị xóa' }}</span>
                                    <span class="text-3xs text-gray-500 font-mono">({{ $order->user->email ?? 'N/A' }})</span>
                                </div>
                            </td>
                            <td class="py-4 px-4 font-gaming text-gray-400">{{ number_format($order->total_amount, 0, ',', '.') }}đ</td>
                            <td class="py-4 px-4 font-gaming text-gaming-pink">-{{ number_format($order->discount_amount, 0, ',', '.') }}đ</td>
                            <td class="py-4 px-4 font-gaming text-gaming-neon font-bold text-sm">{{ number_format($order->final_amount, 0, ',', '.') }}đ</td>
                            <td class="py-4 px-4">
                                <span class="py-0.5 px-2.5 rounded-full font-bold uppercase tracking-wider bg-green-950/40 text-gaming-neon border border-gaming-neon/20">
                                    {{ $order->status === 'completed' ? 'Hoàn thành' : $order->status }}
                                </span>
                            </td>
                            <td class="py-4 px-4 text-gray-400">{{ $order->created_at->format('d/m/Y H:i') }}</td>
                            <td class="py-4 px-4 text-right">
                                <div class="inline-flex gap-2">
                                    <a href="{{ route('admin.orders.show', $order->id) }}" class="h-8 w-8 rounded-lg bg-gaming-dark hover:bg-gaming-purple border border-gaming-border hover:border-gaming-purple transition-all flex items-center justify-center text-gray-300 hover:text-white" title="Xem chi tiết"><i class="fa-solid fa-eye text-xs"></i></a>
                                    
                                    <form action="{{ route('admin.orders.destroy', $order->id) }}" method="POST" onsubmit="return confirm('Bạn chắc chắn muốn xóa đơn hàng này khỏi lịch sử?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="h-8 w-8 rounded-lg bg-gaming-dark hover:bg-red-500 border border-gaming-border hover:border-red-500 transition-all flex items-center justify-center text-gray-300 hover:text-white" title="Xóa"><i class="fa-solid fa-trash-can text-xs"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="py-12 text-center text-gray-500">Chưa có đơn hàng nào được thực hiện.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($orders->hasPages())
            <div class="mt-6 flex justify-center">
                {{ $orders->links('pagination::tailwind') }}
            </div>
        @endif
    </div>
</div>
@endsection
