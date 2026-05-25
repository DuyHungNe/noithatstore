@extends('layouts.admin')

@section('title', 'Chi Tiet Don Hang')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white shadow rounded-lg p-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Chi Tiet Don Hang</h1>
            <div class="space-x-2">
                <a href="{{ route('admin.orders.edit', $order) }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                    Chinh Sua
                </a>
                <form action="{{ route('admin.orders.destroy', $order) }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600" onclick="return confirm('Ban co chac chan muon xoa don hang nay?')">
                        Xoa
                    </button>
                </form>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
                <h3 class="text-lg font-semibold mb-4">Thong Tin Don Hang</h3>
                <div class="space-y-3">
                    <div>
                        <span class="text-sm text-gray-600">Ma Don:</span>
                        <p class="font-medium">#{{ $order->id }}</p>
                    </div>
                    <div>
                        <span class="text-sm text-gray-600">Ngay Dat:</span>
                        <p class="font-medium">{{ $order->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                    <div>
                        <span class="text-sm text-gray-600">Trang Thai:</span>
                        <p class="font-medium">
                            @if($order->status == 'pending')
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                    Cho Xu Ly
                                </span>
                            @elseif($order->status == 'completed')
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                    Hoan Thanh
                                </span>
                            @else
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                    Da Huy
                                </span>
                            @endif
                        </p>
                    </div>
                    <div>
                        <span class="text-sm text-gray-600">Tong Cong:</span>
                        <p class="font-medium text-green-600 text-lg">${{ number_format($order->total_price, 0) }}</p>
                    </div>
                </div>
            </div>

            <div>
                <h3 class="text-lg font-semibold mb-4">Thong Tin Khach Hang</h3>
                <div class="space-y-3">
                    <div>
                        <span class="text-sm text-gray-600">Ten:</span>
                        <p class="font-medium">{{ $order->user->name }}</p>
                    </div>
                    <div>
                        <span class="text-sm text-gray-600">Email:</span>
                        <p class="font-medium">{{ $order->user->email }}</p>
                    </div>
                    <div>
                        <span class="text-sm text-gray-600">Dien Thoai:</span>
                        <p class="font-medium">{{ $order->user->phone ?? 'Chua co' }}</p>
                    </div>
                    <div>
                        <span class="text-sm text-gray-600">Dia Chi:</span>
                        <p class="font-medium">{{ $order->user->address ?? 'Chua co' }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="mb-6">
            <h3 class="text-lg font-semibold mb-4">Chi Tiet San Pham</h3>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">San Pham</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">So Luong</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Gia</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Thanh Tien</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($order->orderItems as $item)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        @if($item->product->image)
                                            <img src="{{ asset($item->product->image) }}" alt="{{ $item->product->name }}" 
                                                class="w-10 h-10 object-cover rounded mr-3">
                                        @else
                                            <div class="w-10 h-10 bg-gray-200 rounded mr-3 flex items-center justify-center">
                                                <span class="text-gray-500 text-xs">No Img</span>
                                            </div>
                                        @endif
                                        <div>
                                            <div class="text-sm font-medium text-gray-900">{{ $item->product->name }}</div>
                                            <div class="text-sm text-gray-500">{{ Str::limit($item->product->description, 50) }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $item->quantity }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    ${{ number_format($item->price, 0) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    ${{ number_format($item->quantity * $item->price, 0) }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="bg-gray-50 p-4 rounded">
            <div class="flex justify-between items-center">
                <div>
                    <span class="text-sm text-gray-600">Tong San Pham:</span>
                    <span class="font-medium ml-2">{{ $order->orderItems->sum('quantity') }}</span>
                </div>
                <div>
                    <span class="text-sm text-gray-600">Tong Cong:</span>
                    <span class="text-xl font-bold text-green-600 ml-2">${{ number_format($order->total_price, 0) }}</span>
                </div>
            </div>
        </div>

        <div class="mt-6">
            <a href="{{ route('admin.orders.index') }}" class="text-blue-600 hover:text-blue-800">
                &larr; Quay Lai Danh Sach Don Hang
            </a>
        </div>
    </div>
</div>
@endsection
