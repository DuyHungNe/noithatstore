@extends('layouts.user')

@section('title', $product->name)

@section('content')
<section class="py-12">
    <div class="max-w-7xl mx-auto px-4">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
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
            </div>

            <div class="space-y-6">
                <div>
                    <div class="mb-2">
                        <span class="text-sm text-orange-600 font-semibold">{{ $product->category->name ?? 'Chưa phân loại' }}</span>
                    </div>
                    <h1 class="text-3xl font-bold text-gray-900 mb-4">{{ $product->name }}</h1>
                    <div class="flex items-center space-x-4 mb-4">
                        <span class="text-3xl font-bold text-orange-600">{{ number_format($product->price, 0) }} VND</span>
                        <span class="px-3 py-1 rounded-full text-sm font-semibold {{ $product->stock > 0 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $product->stock > 0 ? $product->stock . ' trong kho' : 'Hết hàng' }}
                        </span>
                    </div>
                </div>

                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Mô tả chi tiết</h3>
                    <p class="text-gray-600 leading-relaxed">{{ $product->description ?: 'Chưa có mô tả chi tiết cho sản phẩm này.' }}</p>
                </div>

                <div class="border-t pt-6">
                    <form action="{{ route('cart.add', $product) }}" method="POST" class="space-y-4">
                        @csrf
                        <label class="block text-sm font-medium text-gray-700">Số lượng</label>
                        <div class="flex gap-4 items-center">
                            <input type="number" name="quantity" value="1" min="1" max="{{ $product->stock }}" class="w-24 px-3 py-2 border rounded-lg">
                            <button type="submit" class="flex-1 bg-orange-600 text-white py-3 px-6 rounded-lg hover:bg-orange-700 transition disabled:opacity-50" {{ $product->stock <= 0 ? 'disabled' : '' }}>
                                {{ $product->stock > 0 ? 'Thêm vào giỏ hàng' : 'Hết hàng' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
