@extends('layouts.user')

@section('title', 'Trang Chû')

@section('content')
<!-- Hero Section -->
<section class="bg-gradient-to-r from-orange-500 to-orange-600 text-white py-20">
    <div class="max-w-7xl mx-auto px-4 text-center">
        <h1 class="text-4xl md:text-6xl font-bold mb-4">Nôi Thât Store</h1>
        <p class="text-xl md:text-2xl mb-8">Chuyên cung câp nôi thât cao câp cho không gian sông cûa ban</p>
        <a href="/products" class="bg-white text-orange-600 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition">
            Xem Sân Phâm
        </a>
    </div>
</section>

<!-- Categories Section -->
<section class="py-16">
    <div class="max-w-7xl mx-auto px-4">
        <h2 class="text-3xl font-bold text-center mb-12">Danh Muc Phô Biên</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach($categories as $category)
                <div class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition">
                    @if($category->image)
                        <img src="{{ $category->image }}" alt="{{ $category->name }}" class="w-full h-48 object-cover">
                    @else
                        <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                            <span class="text-gray-500">{{ $category->name }}</span>
                        </div>
                    @endif
                    <div class="p-6">
                        <h3 class="text-xl font-semibold mb-2">{{ $category->name }}</h3>
                        <p class="text-gray-600 mb-4">{{ Str::limit($category->description, 100) }}</p>
                        <a href="/category/{{ $category->id }}" class="text-orange-600 hover:text-orange-700 font-semibold">
                            Xem Chi Tiêt &rarr;
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Featured Products -->
<section class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4">
        <h2 class="text-3xl font-bold text-center mb-12">Sân Phâm Nôi Bât</h2>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            @foreach($featuredProducts as $product)
                <div class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition">
                    @if($product->image)
                        <img src="{{ $product->image }}" alt="{{ $product->name }}" class="w-full h-48 object-cover">
                    @else
                        <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                            <span class="text-gray-500 text-sm">No Image</span>
                        </div>
                    @endif
                    <div class="p-4">
                        <h3 class="font-semibold text-lg mb-2">{{ $product->name }}</h3>
                        <p class="text-gray-600 text-sm mb-2">{{ $product->category->name ?? 'Uncategorized' }}</p>
                        <div class="flex justify-between items-center">
                            <span class="text-xl font-bold text-orange-600">${{ number_format($product->price, 0) }}</span>
                            <span class="text-sm text-gray-500">{{ $product->stock }} trong kho</span>
                        </div>
                        <a href="/product/{{ $product->id }}" class="mt-4 block w-full bg-orange-600 text-white text-center py-2 rounded hover:bg-orange-700 transition">
                            Xem Chi Tiêt
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="text-center mt-12">
            <a href="/products" class="bg-orange-600 text-white px-8 py-3 rounded-lg font-semibold hover:bg-orange-700 transition">
                Xem Tât Ca Sân Phâm
            </a>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="py-16">
    <div class="max-w-7xl mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="text-center">
                <div class="w-16 h-16 bg-orange-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold mb-2">Chât Luong Ðâm Bâo</h3>
                <p class="text-gray-600">Tât ca sân phâm duoc chon loc ky luong, cam kêan chât luong.</p>
            </div>
            <div class="text-center">
                <div class="w-16 h-16 bg-orange-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold mb-2">Giao Hàng Nhanh</h3>
                <p class="text-gray-600">Giao hàng nhanh chóng trong vòng 24-48 giô trên toàn quôc.</p>
            </div>
            <div class="text-center">
                <div class="w-16 h-16 bg-orange-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold mb-2">Bâo Hành Dài Hân</h3>
                <p class="text-gray-600">Chinh sách bâo hành lên den 24 tháng cho tât ca sân phâm.</p>
            </div>
        </div>
    </div>
</section>
@endsection
