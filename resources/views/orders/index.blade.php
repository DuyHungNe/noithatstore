@extends('layouts.user')

@section('title', 'Đơn hàng')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-10">
    <h1 class="text-3xl font-bold mb-6">Đơn hàng của tôi</h1>

    <div class="space-y-4">
        @forelse($orders as $order)
            <div class="bg-white rounded-xl shadow p-6">
                <div class="flex justify-between items-center mb-3">
                    <div>
                        <h2 class="font-semibold text-lg">Mã đơn #{{ $order->id }}</h2>
                        <p class="text-sm text-gray-500">{{ $order->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                    <div class="text-right">
                        <p class="font-semibold text-orange-600">{{ number_format($order->total_price, 0) }} VND</p>
                        <p class="text-sm">{{ $order->status }}</p>
                    </div>
                </div>
                <div class="text-sm text-gray-700 space-y-1">
                    @foreach($order->orderItems as $item)
                        <div class="flex justify-between">
                            <span>{{ $item->product->name ?? 'Sản phẩm' }} x {{ $item->quantity }}</span>
                            <span>{{ number_format($item->price * $item->quantity, 0) }} VND</span>
                        </div>
                    @endforeach
                </div>
            </div>
        @empty
            <div class="bg-white rounded-xl shadow p-6 text-gray-600">Bạn chưa có đơn hàng nào.</div>
        @endforelse
    </div>

    <div class="mt-6">{{ $orders->links() }}</div>
</div>
@endsection
