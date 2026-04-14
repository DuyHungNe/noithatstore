@extends('layouts.user')

@section('title', $product->name)

@section('content')
<!-- Product Detail Section -->
<section class="py-12">
    <div class="max-w-7xl mx-auto px-4">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
            <!-- Product Image -->
            <div class="space-y-4">
                @if($product->image)
                    <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" class="w-full rounded-lg shadow-lg">
                @else
                    <div class="w-full h-96 bg-gray-200 rounded-lg flex items-center justify-center">
                        <span class="text-gray-500 text-lg">No Image Available</span>
                    </div>
                @endif
                
                <!-- Product Gallery (Placeholder for multiple images) -->
                <div class="grid grid-cols-4 gap-2">
                    @if($product->image)
                        <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" class="w-full h-20 object-cover rounded cursor-pointer hover:opacity-75 transition">
                    @else
                        <div class="w-full h-20 bg-gray-200 rounded cursor-pointer hover:bg-gray-300 transition"></div>
                    @endif
                    <div class="w-full h-20 bg-gray-200 rounded cursor-pointer hover:bg-gray-300 transition"></div>
                    <div class="w-full h-20 bg-gray-200 rounded cursor-pointer hover:bg-gray-300 transition"></div>
                    <div class="w-full h-20 bg-gray-200 rounded cursor-pointer hover:bg-gray-300 transition"></div>
                </div>
            </div>

            <!-- Product Info -->
            <div class="space-y-6">
                <div>
                    <div class="mb-2">
                        <span class="text-sm text-orange-600 font-semibold">
                            {{ $product->category->name ?? 'Chua phân loai' }}
                        </span>
                    </div>
                    <h1 class="text-3xl font-bold text-gray-900 mb-4">{{ $product->name }}</h1>
                    <div class="flex items-center space-x-4 mb-4">
                        <span class="text-3xl font-bold text-orange-600">${{ number_format($product->price, 0) }}</span>
                        <span class="px-3 py-1 rounded-full text-sm font-semibold 
                            {{ $product->stock > 0 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $product->stock > 0 ? $product->stock . ' trong kho' : 'Hêt hàng' }}
                        </span>
                    </div>
                </div>

                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Mô Tã Chi Tiêt</h3>
                    <p class="text-gray-600 leading-relaxed">{{ $product->description ?: 'Chua có mô tã chi tiêt cho sân phâm này.' }}</p>
                </div>

                <div class="border-t pt-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Thông Tin Sân Phâm</h3>
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Danh Muc:</span>
                            <span class="font-medium">{{ $product->category->name ?? 'Chua phân loai' }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Tôn Kho:</span>
                            <span class="font-medium">{{ $product->stock }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Ma Sân Phâm:</span>
                            <span class="font-medium">#{{ $product->id }}</span>
                        </div>
                    </div>
                </div>

                <div class="border-t pt-6">
                    <div class="flex space-x-4">
                        <button class="flex-1 bg-orange-600 text-white py-3 px-6 rounded-lg hover:bg-orange-700 transition disabled:opacity-50 disabled:cursor-not-allowed" 
                                {{ $product->stock <= 0 ? 'disabled' : '' }}>
                            {{ $product->stock > 0 ? 'Thêm Vao Giô Hàng' : 'Hêt Hàng' }}
                        </button>
                        <button class="px-6 py-3 border border-orange-600 text-orange-600 rounded-lg hover:bg-orange-50 transition">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Related Products -->
        @if($relatedProducts->count() > 0)
            <div class="mt-16">
                <h2 class="text-2xl font-bold text-gray-900 mb-8">Sân Phâm Liên Quan</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach($relatedProducts as $relatedProduct)
                        <div class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition">
                            @if($relatedProduct->image)
                                <img src="{{ $relatedProduct->image }}" alt="{{ $relatedProduct->name }}" class="w-full h-48 object-cover">
                            @else
                                <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                                    <span class="text-gray-500">No Image</span>
                                </div>
                            @endif
                            <div class="p-4">
                                <h3 class="font-semibold text-lg mb-2">{{ $relatedProduct->name }}</h3>
                                <div class="flex justify-between items-center mb-3">
                                    <span class="text-xl font-bold text-orange-600">${{ number_format($relatedProduct->price, 0) }}</span>
                                    <span class="text-sm text-gray-500">{{ $relatedProduct->stock }} trong kho</span>
                                </div>
                                <a href="/product/{{ $relatedProduct->id }}" class="block w-full bg-orange-600 text-white text-center py-2 rounded hover:bg-orange-700 transition">
                                    Xem Chi Tiêt
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</section>
@endsection
