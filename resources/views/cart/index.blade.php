@extends('layouts.user')

@section('title', 'Giỏ hàng')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-10">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2 space-y-4">
            <h1 class="text-3xl font-bold text-gray-900">Giỏ hàng của bạn</h1>

            @forelse($cartItems as $item)
                <div class="bg-white rounded-xl shadow p-4 flex gap-4 items-center">
                    <div class="w-24 h-24 bg-gray-100 rounded-lg overflow-hidden">
                        @if($item['product']->image)
                            <img src="{{ asset($item['product']->image) }}" class="w-full h-full object-cover" alt="{{ $item['product']->name }}">
                        @endif
                    </div>
                    <div class="flex-1">
                        <h2 class="font-semibold text-lg">{{ $item['product']->name }}</h2>
                        <p class="text-orange-600 font-bold">{{ number_format($item['product']->price, 0) }} VND</p>
                        <form action="{{ route('cart.update', $item['product']) }}" method="POST" class="flex items-center gap-2 mt-2">
                            @csrf
                            @method('PATCH')
                            <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1" max="{{ $item['product']->stock }}" class="w-24 px-3 py-2 border rounded-lg">
                            <button class="px-3 py-2 bg-gray-800 text-white rounded-lg">Cập nhật</button>
                        </form>
                    </div>
                    <form action="{{ route('cart.remove', $item['product']) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button class="text-red-600">Xóa</button>
                    </form>
                </div>
            @empty
                <div class="bg-white rounded-xl shadow p-6 text-gray-600">Giỏ hàng đang trống.</div>
            @endforelse
        </div>

        <div class="bg-white rounded-xl shadow p-6 h-fit">
            <h2 class="text-xl font-semibold mb-4">Thanh toán COD</h2>
            <div class="space-y-2 text-sm mb-6">
                <div class="flex justify-between"><span>Tạm tính</span><span>{{ number_format($subtotal, 0) }} VND</span></div>
                <div class="flex justify-between"><span>Phí giao hàng</span><span>{{ number_format($shippingFee, 0) }} VND</span></div>
                <div class="flex justify-between font-bold text-lg"><span>Tổng cộng</span><span>{{ number_format($total, 0) }} VND</span></div>
            </div>

            <form action="{{ route('checkout.cod') }}" method="POST" class="space-y-3">
                @csrf
                <input type="text" name="name" value="{{ auth()->user()->name ?? old('name') }}" placeholder="Họ tên" class="w-full px-4 py-2 border rounded-lg">
                <input type="text" name="phone" value="{{ auth()->user()->phone ?? old('phone') }}" placeholder="Số điện thoại" class="w-full px-4 py-2 border rounded-lg">
                <textarea name="address" rows="3" placeholder="Địa chỉ giao hàng" class="w-full px-4 py-2 border rounded-lg">{{ auth()->user()->address ?? old('address') }}</textarea>
                <textarea name="note" rows="3" placeholder="Ghi chú" class="w-full px-4 py-2 border rounded-lg">{{ old('note') }}</textarea>
                <button type="submit" class="w-full bg-orange-600 text-white py-3 rounded-lg hover:bg-orange-700">Đặt hàng COD</button>
            </form>
        </div>
    </div>
</div>
@endsection
