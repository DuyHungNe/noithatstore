@extends('layouts.admin')

@section('title', 'Sửa Danh mục')

@section('content')
<div class="max-w-2xl mx-auto">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Sửa Danh mục</h1>

    <form action="{{ route('admin.categories.update', $category) }}" method="POST" class="bg-white shadow rounded-lg p-6">
        @csrf
        @method('PUT')
        
        <div class="mb-4">
            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Tên Danh mục</label>
            <input type="text" name="name" id="name" value="{{ old('name', $category->name) }}" required
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            @error('name')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="slug" class="block text-sm font-medium text-gray-700 mb-2">Slug (Tự động Tạo)</label>
            <input type="text" id="slug" readonly value="{{ $category->slug }}"
                class="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-50">
            <p class="text-xs text-gray-500 mt-1">Slug sẽ được tự động từ tên danh mục</p>
        </div>

        <div class="mb-4">
            <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Mô tả</label>
            <textarea name="description" id="description" rows="4"
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('description', $category->description) }}</textarea>
            @error('description')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="image" class="block text-sm font-medium text-gray-700 mb-2">Hình ảnh</label>
            @if($category->image)
                <div class="mb-4">
                    <p class="text-sm text-gray-600 mb-2">Hình ảnh hiện tại:</p>
                    <img src="{{ asset($category->image) }}" alt="{{ $category->name }}" class="w-32 h-32 object-cover rounded-lg shadow">
                </div>
            @endif
            <div class="space-y-2">
                <div class="flex items-center justify-center w-full">
                    <div id="imagePreview" class="w-32 h-32 border-2 border-dashed border-gray-300 rounded-lg flex items-center justify-center bg-gray-50">
                        @if($category->image)
                            <img src="{{ asset($category->image) }}" alt="Current" class="w-32 h-32 object-cover rounded-lg">
                        @else
                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-4-4v4a4 4 0 014 4h4a4 4 0 014-4v-4a4 4 0 01-4-4z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0l8.586 8.586a2 2 0 012.828 0L4 16z"></path>
                            </svg>
                        @endif
                        <p class="text-xs text-gray-500 mt-1">Chọn hình ảnh mới</p>
                    </div>
                </div>
                <input type="file" name="image" id="image" accept="image/*"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                    onchange="previewImage(event)">
            </div>
            @error('image')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6">
            <div class="flex items-center">
                <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $category->is_active) ? 'checked' : '' }}
                    class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                <label for="is_active" class="ml-2 block text-sm text-gray-700">
                    Hoạt động
                </label>
            </div>
            <p class="text-xs text-gray-500 mt-1">Bộ tích này sẽ hiển thị danh mục trên trang cửa hàng</p>
        </div>

        <div class="flex justify-end space-x-4">
            <a href="{{ route('admin.categories.index') }}" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                Hủy
            </a>
            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">
                Cập nhật
            </button>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const nameInput = document.getElementById('name');
    const slugInput = document.getElementById('slug');
    
    nameInput.addEventListener('input', function() {
        const slug = this.value.toLowerCase()
            .replace(/[àáâãäå]/g, 'a')
            .replace(/[èéêë]/g, 'e')
            .replace(/[ìíîï]/g, 'i')
            .replace(/[òóôõö]/g, 'o')
            .replace(/[ùúûü]/g, 'u')
            .replace(/[ýýÿ]/g, 'y')
            .replace(/[ñ]/g, 'n')
            .replace(/[ç]/g, 'c')
            .replace(/[^a-z0-9\s-]/g, '')
            .replace(/[\s-]+/g, '-')
            .replace(/^-+|-+$/g, '');
        
        slugInput.value = slug;
    });
});
</script>
@endsection
