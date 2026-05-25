@extends('layouts.admin')

@section('title', 'Chinh Sua Don Hang')

@section('content')
@if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
        {{ session('error') }}
    </div>
@endif

<div class="max-w-4xl mx-auto">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Chinh Sua Don Hang</h1>

    <form action="{{ route('admin.orders.update', $order) }}" method="POST" class="bg-white shadow rounded-lg p-6">
        @csrf
        @method('PUT')
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
                <h3 class="text-lg font-semibold mb-4">Thong Tin Don Hang</h3>
                <div class="space-y-3">
                    <div>
                        <span class="text-sm text-gray-600">Ma Don:</span>
                        <p class="font-medium">#{{ $order->id }}</p>
                    </div>
                    <div>
                        <span class="text-sm text-gray-600">Khach Hang:</span>
                        <p class="font-medium">{{ $order->user->name }}</p>
                        <p class="text-sm text-gray-500">{{ $order->user->email }}</p>
                    </div>
                    <div>
                        <span class="text-sm text-gray-600">Ngay Dat:</span>
                        <p class="font-medium">{{ $order->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                    <div>
                        <span class="text-sm text-gray-600">Tong Cong:</span>
                        <p class="font-medium text-green-600">{{ number_format($order->total_price, 0) }} VND</p>
                    </div>
                </div>
            </div>

            <div>
                <h3 class="text-lg font-semibold mb-4">Trang Thai</h3>
                <div class="space-y-3">
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Trạng thái đơn hàng</label>
                        <select name="status" id="status" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>
                                Chờ xử lý
                            </option>
                            <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>
                                Hoàn thành
                            </option>
                            <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>
                                Hủy
                            </option>
                        </select>
                        @error('status')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
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

        <div class="flex justify-end space-x-4">
            <a href="{{ route('admin.orders.index') }}" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                Huy
            </a>
            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">
                Cap Nhat Don Hang
            </button>
        </div>
    </form>
</div>
@endsection
