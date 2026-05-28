@extends('layouts.app')

@section('title', 'Quản Lý Người Dùng - GameShop Admin')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <!-- Header title -->
    <div class="mb-8 border-b border-gaming-border/40 pb-5 text-left space-y-2">
        <h1 class="font-gaming font-black text-2xl tracking-wider text-white uppercase"><i class="fa-solid fa-users text-gaming-purple mr-2"></i>QUẢN LÝ <span class="bg-gradient-to-r from-gaming-purple to-gaming-pink bg-clip-text text-transparent">NGƯỜI DÙNG</span></h1>
        <p class="text-xs text-gray-400">Xem, điều chỉnh số dư ví, quyền quản trị hoặc xóa thành viên khỏi hệ thống.</p>
    </div>

    <!-- Table Container -->
    <div class="bg-gaming-card border border-gaming-border p-6 rounded-2xl shadow-glass space-y-6">
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm text-left text-gray-400">
                <thead class="text-xs font-bold uppercase tracking-wider text-gray-500 border-b border-gaming-border/80">
                    <tr>
                        <th class="py-3.5 px-4">Mã</th>
                        <th class="py-3.5 px-4">Avatar</th>
                        <th class="py-3.5 px-4">Họ và Tên</th>
                        <th class="py-3.5 px-4">Email</th>
                        <th class="py-3.5 px-4">Số dư ví</th>
                        <th class="py-3.5 px-4">Vai trò</th>
                        <th class="py-3.5 px-4">Ngày đăng ký</th>
                        <th class="py-3.5 px-4 text-right">Thao tác</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gaming-border/50 text-xs">
                    @forelse($users as $user)
                        <tr class="hover:bg-gaming-dark/20 transition-colors">
                            <td class="py-4 px-4 font-gaming text-gray-300">#{{ $user->id }}</td>
                            <td class="py-4 px-4">
                                <img class="h-8 w-8 rounded-full border border-gaming-border object-cover" src="{{ $user->avatar ?? 'https://api.dicebear.com/7.x/bottts/svg?seed=' . $user->email }}" alt="Avatar">
                            </td>
                            <td class="py-4 px-4 font-bold text-white text-sm">{{ $user->name }}</td>
                            <td class="py-4 px-4 text-gray-300 font-mono text-3xs">{{ $user->email }}</td>
                            <td class="py-4 px-4 text-gaming-neon font-gaming font-bold">{{ number_format($user->balance, 0, ',', '.') }}đ</td>
                            <td class="py-4 px-4">
                                <span class="py-0.5 px-2.5 rounded-full font-bold uppercase tracking-wider"
                                    :class="'{{ $user->role }}' === 'admin' ? 'bg-purple-950/40 text-gaming-purple border border-gaming-purple/20' : 'bg-zinc-800 text-gray-300 border border-zinc-700'">
                                    {{ $user->role === 'admin' ? 'Quản Trị Viên' : 'Thành Viên' }}
                                </span>
                            </td>
                            <td class="py-4 px-4 text-gray-400">{{ $user->created_at->format('d/m/Y H:i') }}</td>
                            <td class="py-4 px-4 text-right">
                                <div class="inline-flex gap-2">
                                    <a href="{{ route('admin.users.edit', $user->id) }}" class="h-8 w-8 rounded-lg bg-gaming-dark hover:bg-gaming-purple border border-gaming-border hover:border-gaming-purple transition-all flex items-center justify-center text-gray-300 hover:text-white"><i class="fa-solid fa-pen-to-square text-xs"></i></a>
                                    
                                    @if(Auth::id() !== $user->id)
                                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Bạn chắc chắn muốn xóa tài khoản này?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="h-8 w-8 rounded-lg bg-gaming-dark hover:bg-red-500 border border-gaming-border hover:border-red-500 transition-all flex items-center justify-center text-gray-300 hover:text-white"><i class="fa-solid fa-trash-can text-xs"></i></button>
                                    </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="py-12 text-center text-gray-500">Chưa có người dùng nào.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($users->hasPages())
            <div class="mt-6 flex justify-center">
                {{ $users->links('pagination::tailwind') }}
            </div>
        @endif
    </div>
</div>
@endsection
