@extends('layouts.app')

@section('title', 'Cập Nhật Người Dùng - GameShop Admin')

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <!-- Header title -->
    <div class="mb-8 border-b border-gaming-border/40 pb-5 flex items-center justify-between">
        <div class="text-left space-y-2">
            <h1 class="font-gaming font-black text-2xl tracking-wider text-white uppercase"><i class="fa-solid fa-user-gear text-gaming-purple mr-2"></i>ĐIỀU CHỈNH <span class="bg-gradient-to-r from-gaming-purple to-gaming-pink bg-clip-text text-transparent">NGƯỜI DÙNG</span></h1>
            <p class="text-xs text-gray-400">Thay đổi thông tin cơ bản, vai trò và số dư ví của thành viên #{{ $user->id }}.</p>
        </div>
        <a href="{{ route('admin.users.index') }}" class="text-xs font-bold text-gray-400 hover:text-white transition-colors bg-gaming-card border border-gaming-border px-4 py-2.5 rounded-xl"><i class="fa-solid fa-arrow-left mr-2"></i>Quay lại</a>
    </div>

    <!-- Form Container -->
    <div class="bg-gaming-card border border-gaming-border p-8 rounded-2xl shadow-glass">
        <form action="{{ route('admin.users.update', $user->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- User Name -->
                <div class="space-y-2">
                    <label for="name" class="block text-xs font-bold uppercase tracking-wider text-gray-400">Họ và Tên <span class="text-gaming-pink">*</span></label>
                    <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" class="w-full bg-gaming-dark border border-gaming-border focus:border-gaming-purple rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:ring-1 focus:ring-gaming-purple @error('name') border-red-500 @enderror" required>
                    @error('name')
                        <p class="text-2xs text-red-400 font-semibold">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div class="space-y-2">
                    <label for="email" class="block text-xs font-bold uppercase tracking-wider text-gray-400">Email <span class="text-gaming-pink">*</span></label>
                    <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" class="w-full bg-gaming-dark border border-gaming-border focus:border-gaming-purple rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:ring-1 focus:ring-gaming-purple @error('email') border-red-500 @enderror" required>
                    @error('email')
                        <p class="text-2xs text-red-400 font-semibold">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Wallet Balance -->
                <div class="space-y-2">
                    <label for="balance" class="block text-xs font-bold uppercase tracking-wider text-gray-400">Số dư ví (đ) <span class="text-gaming-pink">*</span></label>
                    <input type="number" id="balance" name="balance" value="{{ old('balance', $user->balance) }}" placeholder="Ví dụ: 500000" class="w-full bg-gaming-dark border border-gaming-border focus:border-gaming-purple rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:ring-1 focus:ring-gaming-purple @error('balance') border-red-500 @enderror" required>
                    <p class="text-3xs text-gray-500 italic"><i class="fa-solid fa-circle-info mr-1"></i>Điều chỉnh số dư ví sẽ tự động tạo một giao dịch kiểm toán ghi nhận lịch sử đổi ví.</p>
                    @error('balance')
                        <p class="text-2xs text-red-400 font-semibold">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Role -->
                <div class="space-y-2">
                    <label for="role" class="block text-xs font-bold uppercase tracking-wider text-gray-400">Vai Trò / Quyền Hạn <span class="text-gaming-pink">*</span></label>
                    <select id="role" name="role" class="w-full bg-gaming-dark border border-gaming-border focus:border-gaming-purple rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:ring-1 focus:ring-gaming-purple @error('role') border-red-500 @enderror" required>
                        <option value="user" {{ old('role', $user->role) === 'user' ? 'selected' : '' }}>Thành Viên (User)</option>
                        <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>Quản Trị Viên (Admin)</option>
                    </select>
                    @error('role')
                        <p class="text-2xs text-red-400 font-semibold">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="w-full bg-gradient-to-r from-gaming-purple to-gaming-pink py-4 rounded-xl text-sm font-bold tracking-widest text-white uppercase hover:opacity-90 shadow-neon-purple/20 transition-all transform hover:-translate-y-0.5"><i class="fa-solid fa-save mr-2"></i>LƯU THAY ĐỔI</button>
        </form>
    </div>
</div>
@endsection
