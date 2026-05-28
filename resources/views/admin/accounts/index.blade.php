@extends('layouts.app')

@section('title', 'Quản Lý Accounts - GameShop Admin')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <!-- Header title with direct create link button -->
    <div class="mb-8 border-b border-gaming-border/40 pb-5 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div class="text-left space-y-2">
            <h1 class="font-gaming font-black text-2xl tracking-wider text-white uppercase"><i class="fa-solid fa-gamepad text-gaming-neon mr-2"></i>QUẢN LÝ <span class="bg-gradient-to-r from-gaming-purple to-gaming-pink bg-clip-text text-transparent">ACCOUNT</span> GAME</h1>
            <p class="text-xs text-gray-400">Danh sách tất cả các tài khoản game được đăng bán trên hệ thống.</p>
        </div>
        
        <a href="{{ route('admin.accounts.create') }}" class="bg-gradient-to-r from-gaming-purple to-gaming-pink font-bold text-xs px-5 py-3 rounded-xl text-white hover:opacity-90 transition-all transform hover:-translate-y-0.5"><i class="fa-solid fa-circle-plus mr-1.5"></i>ĐĂNG BÁN ACC MỚI</a>
    </div>

    <!-- Table Container -->
    <div class="bg-gaming-card border border-gaming-border p-6 rounded-2xl shadow-glass space-y-6">
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm text-left text-gray-400">
                <thead class="text-xs font-bold uppercase tracking-wider text-gray-500 border-b border-gaming-border/80">
                    <tr>
                        <th class="py-3.5 px-4">Mã số</th>
                        <th class="py-3.5 px-4">Hình ảnh</th>
                        <th class="py-3.5 px-4">Tựa Game</th>
                        <th class="py-3.5 px-4">Tiêu đề tài khoản</th>
                        <th class="py-3.5 px-4">Hạng / Rank</th>
                        <th class="py-3.5 px-4">Giá bán</th>
                        <th class="py-3.5 px-4">Trạng thái</th>
                        <th class="py-3.5 px-4">Nổi bật</th>
                        <th class="py-3.5 px-4 text-right">Thao tác</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gaming-border/50 text-xs">
                    @forelse($accounts as $acc)
                        <tr class="hover:bg-gaming-dark/20 transition-colors">
                            <td class="py-4 px-4 font-gaming text-gray-300">#{{ $acc->id }}</td>
                            <td class="py-4 px-4">
                                <div class="h-10 w-16 rounded overflow-hidden bg-gaming-dark border border-gaming-border/60">
                                    <img src="{{ $acc->first_image }}" class="w-full h-full object-cover">
                                </div>
                            </td>
                            <td class="py-4 px-4 font-semibold text-gray-200">{{ $acc->game->name }}</td>
                            <td class="py-4 px-4 font-semibold text-white truncate max-w-[200px]">{{ $acc->title }}</td>
                            <td class="py-4 px-4 text-gaming-neon font-bold">{{ $acc->rank ?? 'N/A' }}</td>
                            <td class="py-4 px-4 font-gaming text-gray-200">{{ number_format($acc->price, 0, ',', '.') }}đ</td>
                            <td class="py-4 px-4">
                                <span class="py-0.5 px-2.5 rounded-full font-bold uppercase"
                                    :class="'{{ $acc->status }}' === 'available' ? 'bg-green-950/40 text-gaming-neon border border-gaming-neon/20' : 'bg-red-950/40 text-red-400 border border-red-500/20'">
                                    {{ $acc->status === 'available' ? 'Còn hàng' : 'Đã bán' }}
                                </span>
                            </td>
                            <td class="py-4 px-4">
                                <span class="text-base" :class="'{{ $acc->is_featured }}' ? 'text-yellow-400' : 'text-gray-600'">
                                    <i class="fa-solid fa-star"></i>
                                </span>
                            </td>
                            <td class="py-4 px-4 text-right">
                                <div class="inline-flex gap-2">
                                    <a href="{{ route('admin.accounts.edit', $acc->id) }}" class="h-8 w-8 rounded-lg bg-gaming-dark hover:bg-gaming-purple border border-gaming-border hover:border-gaming-purple transition-all flex items-center justify-center text-gray-300 hover:text-white"><i class="fa-solid fa-pen-to-square"></i></a>
                                    
                                    <form action="{{ route('admin.accounts.destroy', $acc->id) }}" method="POST" onsubmit="return confirm('Bạn chắc chắn muốn xóa account này?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="h-8 w-8 rounded-lg bg-gaming-dark hover:bg-red-500 border border-gaming-border hover:border-red-500 transition-all flex items-center justify-center text-gray-300 hover:text-white"><i class="fa-solid fa-trash-can"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="py-12 text-center text-gray-500">Chưa có tài khoản game nào được đăng bán.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($accounts->hasPages())
            <div class="mt-6 flex justify-center">
                {{ $accounts->links('pagination::tailwind') }}
            </div>
        @endif
    </div>
</div>
@endsection
