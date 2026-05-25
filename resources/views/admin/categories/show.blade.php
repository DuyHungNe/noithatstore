@extends('layouts.admin')

@section('title', 'Chi tiết Danh mục')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white shadow rounded-lg p-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Chi tiết Danh mục</h1>
            <div class="space-x-2">
                <a href="{{ route('admin.categories.edit', $category) }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                    Sửa
                </a>
                <a href="{{ route('admin.categories.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
                    Quay Lai
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div>
                <h2 class="text-lg font-semibold text-gray-700 mb-4">Thông Tin Danh mục</h2>
                <div class="space-y-3">
                    <div>
                        <span class="font-medium text-gray-600">ID:</span>
                        <span class="text-gray-900 ml-2">{{ $category->id }}</span>
                    </div>
                    <div>
                        <span class="font-medium text-gray-600">Tên Danh mục:</span>
                        <span class="text-gray-900 ml-2">{{ $category->name }}</span>
                    </div>
                    <div>
                        <span class="font-medium text-gray-600">Slug:</span>
                        <span class="text-gray-900 ml-2">{{ $category->slug }}</span>
                    </div>
                    <div>
                        <span class="font-medium text-gray-600">Trang Thái:</span>
                        <span class="ml-2 px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                            {{ $category->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $category->is_active ? 'Hoạt động' : 'Khóa' }}
                        </span>
                    </div>
                    <div>
                        <span class="font-medium text-gray-600">Số lượng Sản phẩm:</span>
                        <span class="text-gray-900 ml-2">{{ $category->products_count ?? $category->products->count() }}</span>
                    </div>
                </div>
            </div>

            <div>
                <h2 class="text-lg font-semibold text-gray-700 mb-4">Thông Tin Thêm</h2>
                <div class="space-y-3">
                    <div>
                        <span class="font-medium text-gray-600">Mô tả:</span>
                        <div class="text-gray-900 ml-2 mt-1">{{ $category->description ?: 'Chưa có mô tả' }}</div>
                    </div>
                    @if($category->image)
                        <div>
                            <span class="font-medium text-gray-600">Hình ảnh:</span>
                            <div class="mt-2">
                                <img src="{{ asset($category->image) }}" alt="{{ $category->name }}" class="w-32 h-32 object-cover rounded-lg shadow">
                            </div>
                        </div>
                    @endif
                    <div>
                        <span class="font-medium text-gray-600">Ngày Tạo:</span>
                        <span class="text-gray-900 ml-2">{{ $category->created_at->format('d/m/Y H:i') }}</span>
                    </div>
                    <div>
                        <span class="font-medium text-gray-600">Cập nhật Cuối:</span>
                        <span class="text-gray-900 ml-2">{{ $category->updated_at->format('d/m/Y H:i') }}</span>
                    </div>
                </div>
            </div>
        </div>

        @if($category->products->count() > 0)
            <div class="mt-8">
                <h2 class="text-lg font-semibold text-gray-700 mb-4">Sân Phâm Trong Danh Muc</h2>
                <div class="bg-gray-50 rounded-lg overflow-hidden">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Mã Sản phẩm</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tên Sản phẩm</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Giá</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tồn kho</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($category->products->take(10) as $product)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">#{{ $product->id }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $product->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${{ number_format($product->price, 0) }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            {{ $product->stock > 0 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ $product->stock }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @if($category->products->count() > 10)
                    <div class="mt-4 text-center">
                        <a href="{{ route('admin.products.index') }}?category_id={{ $category->id }}" class="text-blue-600 hover:text-blue-800">
                            Xem tất cả {{ $category->products->count() }} sản phẩm
                        </a>
                    </div>
                @endif
            </div>
        @else
            <div class="mt-8">
                <h2 class="text-lg font-semibold text-gray-700 mb-4">Sân Phâm Trong Danh Muc</h2>
                <div class="bg-gray-50 rounded-lg p-8 text-center text-gray-500">
                    Chưa có sản phẩm nào trong danh mục này
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
