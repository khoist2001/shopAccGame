@extends('layouts.app')

@section('title', 'Quản Lý Danh Mục Game - GameShop Admin')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <!-- Header title with direct create link button -->
    <div class="mb-8 border-b border-gaming-border/40 pb-5 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div class="text-left space-y-2">
            <h1 class="font-gaming font-black text-2xl tracking-wider text-white uppercase"><i class="fa-solid fa-folder-open text-gaming-purple mr-2"></i>QUẢN LÝ <span class="bg-gradient-to-r from-gaming-purple to-gaming-pink bg-clip-text text-transparent">DANH MỤC GAME</span></h1>
            <p class="text-xs text-gray-400">Tạo mới, cập nhật hoặc xóa các danh mục game trên cửa hàng.</p>
        </div>
        
        <a href="{{ route('admin.games.create') }}" class="bg-gradient-to-r from-gaming-purple to-gaming-pink font-bold text-xs px-5 py-3 rounded-xl text-white hover:opacity-90 transition-all transform hover:-translate-y-0.5"><i class="fa-solid fa-plus-circle mr-1.5"></i>TẠO DANH MỤC MỚI</a>
    </div>

    <!-- Table Container -->
    <div class="bg-gaming-card border border-gaming-border p-6 rounded-2xl shadow-glass space-y-6">
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm text-left text-gray-400">
                <thead class="text-xs font-bold uppercase tracking-wider text-gray-500 border-b border-gaming-border/80">
                    <tr>
                        <th class="py-3.5 px-4">Mã</th>
                        <th class="py-3.5 px-4">Ảnh bìa</th>
                        <th class="py-3.5 px-4">Tên Game</th>
                        <th class="py-3.5 px-4">Slug (Đường dẫn)</th>
                        <th class="py-3.5 px-4">Mô tả danh mục</th>
                        <th class="py-3.5 px-4">Số Account bán</th>
                        <th class="py-3.5 px-4 text-right">Thao tác</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gaming-border/50 text-xs">
                    @forelse($games as $game)
                        <tr class="hover:bg-gaming-dark/20 transition-colors">
                            <td class="py-4 px-4 font-gaming text-gray-300">#{{ $game->id }}</td>
                            <td class="py-4 px-4">
                                <div class="h-10 w-16 rounded overflow-hidden bg-gaming-dark border border-gaming-border/60">
                                    <img src="{{ $game->image ?? 'https://images.unsplash.com/photo-1542751371-adc38448a05e?q=80&w=2070' }}" class="w-full h-full object-cover">
                                </div>
                            </td>
                            <td class="py-4 px-4 font-bold text-white text-sm">{{ $game->name }}</td>
                            <td class="py-4 px-4 font-mono text-gray-400 text-3xs">{{ $game->slug }}</td>
                            <td class="py-4 px-4 text-gray-300 truncate max-w-[250px]">{{ $game->description ?? 'Chưa có mô tả' }}</td>
                            <td class="py-4 px-4 text-gaming-neon font-gaming font-bold">{{ $game->accounts_count }} acc</td>
                            <td class="py-4 px-4 text-right">
                                <div class="inline-flex gap-2">
                                    <a href="{{ route('admin.games.edit', $game->id) }}" class="h-8 w-8 rounded-lg bg-gaming-dark hover:bg-gaming-purple border border-gaming-border hover:border-gaming-purple transition-all flex items-center justify-center text-gray-300 hover:text-white"><i class="fa-solid fa-pen-to-square text-xs"></i></a>
                                    
                                    <form action="{{ route('admin.games.destroy', $game->id) }}" method="POST" onsubmit="return confirm('Bạn chắc chắn muốn xóa danh mục game này? Tất cả acc thuộc game cũng sẽ chịu ảnh hưởng.')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="h-8 w-8 rounded-lg bg-gaming-dark hover:bg-red-500 border border-gaming-border hover:border-red-500 transition-all flex items-center justify-center text-gray-300 hover:text-white"><i class="fa-solid fa-trash-can text-xs"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-12 text-center text-gray-500">Chưa có danh mục game nào được tạo.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($games->hasPages())
            <div class="mt-6 flex justify-center">
                {{ $games->links('pagination::tailwind') }}
            </div>
        @endif
    </div>
</div>
@endsection
