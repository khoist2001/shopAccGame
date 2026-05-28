@extends('layouts.app')

@section('title', 'Tạo Danh Mục Game - GameShop Admin')

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <!-- Header title -->
    <div class="mb-8 border-b border-gaming-border/40 pb-5 flex items-center justify-between">
        <div class="text-left space-y-2">
            <h1 class="font-gaming font-black text-2xl tracking-wider text-white uppercase"><i class="fa-solid fa-folder-plus text-gaming-neon mr-2"></i>TẠO <span class="bg-gradient-to-r from-gaming-purple to-gaming-pink bg-clip-text text-transparent">DANH MỤC GAME</span></h1>
            <p class="text-xs text-gray-400">Đăng kí một tựa game mới vào hệ thống danh mục bán acc.</p>
        </div>
        <a href="{{ route('admin.games.index') }}" class="text-xs font-bold text-gray-400 hover:text-white transition-colors bg-gaming-card border border-gaming-border px-4 py-2.5 rounded-xl"><i class="fa-solid fa-arrow-left mr-2"></i>Quay lại</a>
    </div>

    <!-- Form Container -->
    <div class="bg-gaming-card border border-gaming-border p-8 rounded-2xl shadow-glass">
        <form action="{{ route('admin.games.store') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Game Name -->
            <div class="space-y-2">
                <label for="name" class="block text-xs font-bold uppercase tracking-wider text-gray-400">Tên Game <span class="text-gaming-pink">*</span></label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" placeholder="Ví dụ: Liên Minh Huyền Thoại, Valorant, Free Fire..." class="w-full bg-gaming-dark border border-gaming-border focus:border-gaming-purple rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:ring-1 focus:ring-gaming-purple @error('name') border-red-500 @enderror" required>
                @error('name')
                    <p class="text-2xs text-red-400 font-semibold">{{ $message }}</p>
                @enderror
            </div>

            <!-- Image URL -->
            <div class="space-y-2">
                <label for="image" class="block text-xs font-bold uppercase tracking-wider text-gray-400">Link Ảnh Bìa Danh Mục (URL)</label>
                <input type="url" id="image" name="image" value="{{ old('image') }}" placeholder="Ví dụ: https://images.unsplash.com/photo-..." class="w-full bg-gaming-dark border border-gaming-border focus:border-gaming-purple rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:ring-1 focus:ring-gaming-purple @error('image') border-red-500 @enderror">
                <p class="text-3xs text-gray-500 italic"><i class="fa-solid fa-circle-info mr-1"></i>Có thể sử dụng ảnh từ Unsplash hoặc Imgur có sẵn.</p>
                @error('image')
                    <p class="text-2xs text-red-400 font-semibold">{{ $message }}</p>
                @enderror
            </div>

            <!-- Description -->
            <div class="space-y-2">
                <label for="description" class="block text-xs font-bold uppercase tracking-wider text-gray-400">Mô Tả Tóm Tắt</label>
                <textarea id="description" name="description" rows="4" placeholder="Nhập một vài mô tả ngắn gọn về danh mục game này..." class="w-full bg-gaming-dark border border-gaming-border focus:border-gaming-purple rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:ring-1 focus:ring-gaming-purple @error('description') border-red-500 @enderror">{{ old('description') }}</textarea>
                @error('description')
                    <p class="text-2xs text-red-400 font-semibold">{{ $message }}</p>
                @enderror
            </div>

            <!-- Submit Button -->
            <button type="submit" class="w-full bg-gradient-to-r from-gaming-purple to-gaming-pink py-4 rounded-xl text-sm font-bold tracking-widest text-white uppercase hover:opacity-90 shadow-neon-purple/20 transition-all transform hover:-translate-y-0.5"><i class="fa-solid fa-save mr-2"></i>TẠO DANH MỤC GAME</button>
        </form>
    </div>
</div>
@endsection
