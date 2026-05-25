@extends('layouts.user')

@section('title', 'Sản Phẩm')

@section('content')
<!-- Hero Section -->
<section class="bg-gradient-to-r from-orange-500 to-orange-600 text-white py-12">
    <div class="max-w-7xl mx-auto px-4 text-center">
        <h1 class="text-3xl md:text-4xl font-bold mb-4">Sản Phẩm Nội Thất</h1>
        <p class="text-xl">Khám phá bộ sưu tập nội thất cao cấp cho không gian sống của bạn</p>
    </div>
</section>

<!-- Search and Filter Section -->
<section class="py-8 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4">
        <div class="flex flex-col md:flex-row gap-4 items-center justify-between">
            <form method="GET" class="flex-1 flex gap-4">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Tìm theo tên, mô tả hoặc danh mục..."
                    class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500">
                <button type="submit" class="bg-orange-600 text-white px-6 py-2 rounded-lg hover:bg-orange-700 transition">
                    Tìm kiếm
                </button>
            </form>
            
            <form method="GET" class="flex gap-4 items-center">
                <input type="hidden" name="search" value="{{ request('search') }}">
                <select name="category" onchange="this.form.submit()"
                    class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500">
                    <option value="">Tất cả danh mục</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </form>
        </div>
    </div>
</section>

<!-- Products Grid -->
<section class="py-12">
    <div class="max-w-7xl mx-auto px-4">
        @if($products->count() > 0)
            @if(request('search') || request('category'))
                <div class="mb-6 text-sm text-gray-600">
                    Đang lọc theo:
                    @if(request('search'))
                        <span class="font-semibold">"{{ request('search') }}"</span>
                    @endif
                    @if(request('category'))
                        <span class="font-semibold">danh mục</span>
                    @endif
                </div>
            @endif
            <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach($products as $product)
                    <div class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition">
                        @if($product->image)
                            <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" class="w-full h-48 object-cover">
                        @else
                            <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                                <span class="text-gray-500">Không có hình ảnh</span>
                            </div>
                        @endif
                        <div class="p-4">
                            <div class="mb-2">
                                <span class="text-xs text-orange-600 font-semibold">
                                    {{ $product->category->name ?? 'Chưa phân loại' }}
                                </span>
                            </div>
                            <h3 class="font-semibold text-lg mb-2 text-gray-800">{{ $product->name }}</h3>
                            <p class="text-gray-600 text-sm mb-3">{{ Str::limit($product->description, 80) }}</p>
                            <div class="flex justify-between items-center mb-3">
                                <span class="text-xl font-bold text-orange-600">{{ number_format($product->price, 0) }} VND</span>
                                <span class="text-sm {{ $product->stock > 0 ? 'text-green-600' : 'text-red-600' }}">
                                    {{ $product->stock > 0 ? $product->stock . ' trong kho' : 'Hết hàng' }}
                                </span>
                            </div>
                            <a href="/product/{{ $product->id }}" 
                                class="block w-full bg-orange-600 text-white text-center py-2 rounded hover:bg-orange-700 transition {{ $product->stock <= 0 ? 'opacity-50 cursor-not-allowed' : '' }}">
                                {{ $product->stock > 0 ? 'Xem chi tiết' : 'Hết Hàng' }}
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <div class="mt-12">
                {{ $products->links() }}
            </div>
        @else
            <div class="text-center py-12">
                <div class="text-gray-400 text-6xl mb-4">
                    <svg class="w-24 h-24 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-700 mb-2">Không tìm thấy sản phẩm</h3>
                <p class="text-gray-500">Không có sản phẩm nào phù hợp với tiêu chí tìm kiếm của bạn.</p>
                <a href="/products" class="mt-4 inline-block bg-orange-600 text-white px-6 py-2 rounded-lg hover:bg-orange-700 transition">
                    Xem tất cả sản phẩm
                </a>
            </div>
        @endif
    </div>
</section>
@endsection
