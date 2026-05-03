@extends('layouts.admin')

@section('title', 'Chi Tiet San Pham')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white shadow rounded-lg p-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Chi Tiet San Pham</h1>
            <div class="space-x-2">
                <a href="{{ route('admin.products.edit', $product) }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                    Chinh Sua
                </a>
                <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600" onclick="return confirm('Ban co chac chan muon xoa san pham nay?')">
                        Xoa
                    </button>
                </form>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <h3 class="text-lg font-semibold mb-4">Thong Tin Co Ban</h3>
                <div class="space-y-3">
                    <div>
                        <span class="text-sm text-gray-600">Ten San Pham:</span>
                        <p class="font-medium">{{ $product->name }}</p>
                    </div>
                    <div>
                        <span class="text-sm text-gray-600">Danh Muc:</span>
                        <p class="font-medium">{{ $product->category->name ?? 'Chua Phan Loai' }}</p>
                    </div>
                    <div>
                        <span class="text-sm text-gray-600">Gia:</span>
                        <p class="font-medium text-green-600">${{ number_format($product->price, 0) }}</p>
                    </div>
                    <div>
                        <span class="text-sm text-gray-600">Ton Kho:</span>
                        <p class="font-medium">{{ $product->stock }}</p>
                    </div>
                    <div>
                        <span class="text-sm text-gray-600">Trang Thai:</span>
                        <p class="font-medium">
                            @if($product->stock > 0)
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                    Con Hang
                                </span>
                            @else
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                    Het Hang
                                </span>
                            @endif
                        </p>
                    </div>
                </div>
            </div>

            <div>
                <h3 class="text-lg font-semibold mb-4">Hinh Anh</h3>
                @if($product->image)
                    <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" class="w-full max-w-sm rounded-lg shadow">
                @else
                    <div class="w-full max-w-sm h-64 bg-gray-200 rounded-lg flex items-center justify-center">
                        <span class="text-gray-500">Khong Co Hinh Anh</span>
                    </div>
                @endif
            </div>
        </div>

        <div class="mt-6">
            <h3 class="text-lg font-semibold mb-4">Mo Ta</h3>
            <div class="bg-gray-50 p-4 rounded">
                <p class="text-gray-700">{{ $product->description ?: 'Khong co mo ta' }}</p>
            </div>
        </div>

        <div class="mt-6">
            <h3 class="text-lg font-semibold mb-4">Thong Tin Don Hang</h3>
            <div class="bg-gray-50 p-4 rounded">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <span class="text-sm text-gray-600">So Lan Da Ban:</span>
                        <p class="font-medium">{{ $product->orderItems->sum('quantity') }}</p>
                    </div>
                    <div>
                        <span class="text-sm text-gray-600">Tong Doanh Thu:</span>
                        <p class="font-medium text-green-600">
                            ${{ number_format($product->orderItems->sum(function($item) { return $item->quantity * $item->price; }), 0) }}
                        </p>
                    </div>
                    <div>
                        <span class="text-sm text-gray-600">Ngay Tao:</span>
                        <p class="font-medium">{{ $product->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-6">
            <a href="{{ route('admin.products.index') }}" class="text-blue-600 hover:text-blue-800">
                &larr; Quay Lai Danh Sach San Pham
            </a>
        </div>
    </div>
</div>
@endsection
