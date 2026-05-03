@extends('layouts.admin')

@section('title', 'Quản lý Danh mục')

@section('content')
@if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
        {{ session('error') }}
    </div>
@endif

<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Quản lý Danh mục</h1>
    <a href="{{ route('admin.categories.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
        Thêm Danh mục Mới
    </a>
</div>

<div class="bg-white shadow rounded-lg overflow-hidden">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tên Danh mục</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Slug</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Số lượng Sản phẩm</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Trang Thái</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Hành động</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @foreach($categories as $category)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $category->id }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            @if($category->image)
                                <img src="{{ asset($category->image) }}" alt="{{ $category->name }}" class="w-10 h-10 object-cover rounded mr-3">
                            @else
                                <div class="w-10 h-10 bg-gray-200 rounded mr-3 flex items-center justify-center">
                                    <span class="text-gray-500 text-xs">No Img</span>
                                </div>
                            @endif
                            <div>
                                <div class="text-sm font-medium text-gray-900">{{ $category->name }}</div>
                                <div class="text-sm text-gray-500">{{ Str::limit($category->description, 50) }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $category->slug }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $category->products_count }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                            {{ $category->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $category->is_active ? 'Hoạt động' : 'Khóa' }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <a href="{{ route('admin.categories.show', $category) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">Xem</a>
                        <a href="{{ route('admin.categories.edit', $category) }}" class="text-blue-600 hover:text-blue-900 mr-3">Sûa</a>
                        <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Bạn có chắc chắn muốn xóa danh mục này?')">Xóa</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="mt-6">
    {{ $categories->links() }}
</div>
@endsection
