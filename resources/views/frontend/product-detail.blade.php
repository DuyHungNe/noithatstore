@extends('layouts.user')

@section('title', $product->name)

@section('content')
<!-- Product Detail Section -->
<section class="py-12">
    <div class="max-w-7xl mx-auto px-4">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
            <!-- Product Image -->
            <div class="space-y-4">
                @php
                    $galleryImages = $product->images ?? collect();
                    $primaryImage = $galleryImages->firstWhere('is_primary', true);
                    $mainImage = $primaryImage?->path ?? $product->image;
                @endphp

                <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100">
                    @if($mainImage)
                        <img id="mainProductImage" src="{{ asset($mainImage) }}" alt="{{ $product->name }}" class="w-full h-[420px] object-cover">
                    @else
                        <div class="w-full h-[420px] bg-gray-200 flex items-center justify-center">
                            <span class="text-gray-500 text-lg">Không có hình ảnh</span>
                        </div>
                    @endif
                </div>

                @if($galleryImages->count() > 0 || $product->image)
                    <div class="grid grid-cols-4 gap-3">
                        @if($mainImage)
                            <button type="button" class="thumbnail-item border-2 border-orange-500 rounded-lg overflow-hidden" data-image="{{ asset($mainImage) }}">
                                <img src="{{ asset($mainImage) }}" alt="{{ $product->name }}" class="w-full h-20 object-cover">
                            </button>
                        @endif

                        @foreach($galleryImages->where('path', '!=', $mainImage)->take(3) as $galleryImage)
                            <button type="button" class="thumbnail-item border-2 border-transparent rounded-lg overflow-hidden" data-image="{{ asset($galleryImage->path) }}">
                                <img src="{{ asset($galleryImage->path) }}" alt="{{ $product->name }}" class="w-full h-20 object-cover">
                            </button>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Product Info -->
            <div class="space-y-6">
                <div>
                    <div class="mb-2">
                        <span class="text-sm text-orange-600 font-semibold">
                            {{ $product->category->name ?? 'Chưa phân loại' }}
                        </span>
                    </div>
                    <h1 class="text-3xl font-bold text-gray-900 mb-4">{{ $product->name }}</h1>
                    <div class="flex items-center space-x-4 mb-4">
                        <span class="text-3xl font-bold text-orange-600">{{ number_format($product->price, 0) }} VND</span>
                        <span class="px-3 py-1 rounded-full text-sm font-semibold 
                            {{ $product->stock > 0 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $product->stock > 0 ? $product->stock . ' trong kho' : 'Hết hàng' }}
                        </span>
                    </div>
                </div>

                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Mô tả chi tiết</h3>
                    <p class="text-gray-600 leading-relaxed">{{ $product->description ?: 'Chưa có mô tả chi tiết cho sản phẩm này.' }}</p>
                </div>

                <div class="border-t pt-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Thông tin sản phẩm</h3>
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Danh mục:</span>
                            <span class="font-medium">{{ $product->category->name ?? 'Chưa phân loại' }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Tồn kho:</span>
                            <span class="font-medium">{{ $product->stock }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Mã sản phẩm:</span>
                            <span class="font-medium">#{{ $product->id }}</span>
                        </div>
                    </div>
                </div>

                <div class="border-t pt-6">
                    <div class="flex space-x-4">
                        <button class="flex-1 bg-orange-600 text-white py-3 px-6 rounded-lg hover:bg-orange-700 transition disabled:opacity-50 disabled:cursor-not-allowed" 
                                {{ $product->stock <= 0 ? 'disabled' : '' }}>
                            {{ $product->stock > 0 ? 'Thêm vào giỏ hàng' : 'Hết hàng' }}
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
                <h2 class="text-2xl font-bold text-gray-900 mb-8">Sản phẩm liên quan</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach($relatedProducts as $relatedProduct)
                        <div class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition">
                            @if($relatedProduct->image)
                                <img src="{{ asset($relatedProduct->image) }}" alt="{{ $relatedProduct->name }}" class="w-full h-48 object-cover">
                            @else
                                <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                                    <span class="text-gray-500">Không có hình ảnh</span>
                                </div>
                            @endif
                            <div class="p-4">
                                <h3 class="font-semibold text-lg mb-2">{{ $relatedProduct->name }}</h3>
                                <div class="flex justify-between items-center mb-3">
                                    <span class="text-xl font-bold text-orange-600">{{ number_format($relatedProduct->price, 0) }} VND</span>
                                    <span class="text-sm text-gray-500">{{ $relatedProduct->stock }} trong kho</span>
                                </div>
                                <a href="/product/{{ $relatedProduct->id }}" class="block w-full bg-orange-600 text-white text-center py-2 rounded hover:bg-orange-700 transition">
                                    Xem chi tiết
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</section>

<script>
document.querySelectorAll('.thumbnail-item').forEach((item) => {
    item.addEventListener('click', () => {
        const mainImage = document.getElementById('mainProductImage');
        const imageUrl = item.getAttribute('data-image');
        if (mainImage && imageUrl) {
            mainImage.src = imageUrl;
        }
    });
});
</script>
@endsection
