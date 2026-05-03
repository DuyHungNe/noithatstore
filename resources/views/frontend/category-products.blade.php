@extends('layouts.user')

@section('title', $category->name)

@section('content')
<!-- Hero Section -->
<section class="bg-gradient-to-r from-orange-500 to-orange-600 text-white py-12">
    <div class="max-w-7xl mx-auto px-4 text-center">
        <h1 class="text-3xl md:text-4xl font-bold mb-4">{{ $category->name }}</h1>
        <p class="text-xl">{{ $category->description }}</p>
    </div>
</section>

<!-- Products Section -->
<section class="py-12">
    <div class="max-w-7xl mx-auto px-4">
        @if($products->count() > 0)
            <div class="flex justify-between items-center mb-8">
                <h2 class="text-2xl font-bold text-gray-800">{{ $products->count() }} Sản Phẩm Trong Danh Mục</h2>
                <a href="/products" class="text-orange-600 hover:text-orange-700">
                    Xem Tât Ca Sân Phâm &rarr;
                </a>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach($products as $product)
                    <div class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition">
                        @if($product->image)
                            <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" class="w-full h-48 object-cover">
                        @else
                            <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                                <span class="text-gray-500">No Image</span>
                            </div>
                        @endif
                        <div class="p-4">
                            <h3 class="font-semibold text-lg mb-2 text-gray-800">{{ $product->name }}</h3>
                            <p class="text-gray-600 text-sm mb-3">{{ Str::limit($product->description, 80) }}</p>
                            <div class="flex justify-between items-center mb-3">
                                <span class="text-xl font-bold text-orange-600">${{ number_format($product->price, 0) }}</span>
                                <span class="text-sm {{ $product->stock > 0 ? 'text-green-600' : 'text-red-600' }}">
                                    {{ $product->stock > 0 ? $product->stock . ' trong kho' : 'Hết hàng' }}
                                </span>
                            </div>
                            <a href="/product/{{ $product->id }}" 
                                class="block w-full bg-orange-600 text-white text-center py-2 rounded hover:bg-orange-700 transition {{ $product->stock <= 0 ? 'opacity-50 cursor-not-allowed' : '' }}">
                                {{ $product->stock > 0 ? 'Xem Chi Tiết' : 'Hết Hàng' }}
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
                <h3 class="text-xl font-semibold text-gray-700 mb-2">Không Có Sản Phẩm Nào</h3>
                <p class="text-gray-500">Hiện tại không có sản phẩm nào trong danh mục "{{ $category->name }}".</p>
                <a href="/products" class="mt-4 inline-block bg-orange-600 text-white px-6 py-2 rounded-lg hover:bg-orange-700 transition">
                    Xem Tât Ca Sân Phâm
                </a>
            </div>
        @endif
    </div>
</section>
@endsection
