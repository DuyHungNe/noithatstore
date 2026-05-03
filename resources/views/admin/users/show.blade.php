@extends('layouts.admin')

@section('title', 'Chi tiết Người dùng')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white shadow rounded-lg p-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Chi tiết Người dùng</h1>
            <div class="space-x-2">
                <a href="{{ route('admin.users.edit', $user) }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                    Sửa
                </a>
                <a href="{{ route('admin.users.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
                    Quay Lai
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <h2 class="text-lg font-semibold text-gray-700 mb-4">Thông Tin Cá Nhân</h2>
                <div class="space-y-3">
                    <div>
                        <span class="font-medium text-gray-600">ID:</span>
                        <span class="text-gray-900 ml-2">{{ $user->id }}</span>
                    </div>
                    <div>
                        <span class="font-medium text-gray-600">Họ và Tên:</span>
                        <span class="text-gray-900 ml-2">{{ $user->name }}</span>
                    </div>
                    <div>
                        <span class="font-medium text-gray-600">Email:</span>
                        <span class="text-gray-900 ml-2">{{ $user->email }}</span>
                    </div>
                    <div>
                        <span class="font-medium text-gray-600">Điện thoại:</span>
                        <span class="text-gray-900 ml-2">{{ $user->phone ?? 'Chua có' }}</span>
                    </div>
                    <div>
                        <span class="font-medium text-gray-600">Vai trò:</span>
                        <span class="ml-2 px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                            {{ $user->role == 'admin' ? 'bg-purple-100 text-purple-800' : 'bg-green-100 text-green-800' }}">
                            {{ $user->role == 'admin' ? 'Admin' : 'User' }}
                        </span>
                    </div>
                </div>
            </div>

            <div>
                <h2 class="text-lg font-semibold text-gray-700 mb-4">Thông Tin Thêm</h2>
                <div class="space-y-3">
                    <div>
                        <span class="font-medium text-gray-600">Địa Chỉ:</span>
                        <span class="text-gray-900 ml-2">{{ $user->address ?? 'Chua có' }}</span>
                    </div>
                    <div>
                        <span class="font-medium text-gray-600">Ngày Tạo:</span>
                        <span class="text-gray-900 ml-2">{{ $user->created_at->format('d/m/Y H:i') }}</span>
                    </div>
                    <div>
                        <span class="font-medium text-gray-600">Cập nhật Cuối:</span>
                        <span class="text-gray-900 ml-2">{{ $user->updated_at->format('d/m/Y H:i') }}</span>
                    </div>
                </div>
            </div>
        </div>

        @if($user->orders->count() > 0)
            <div class="mt-8">
                <h2 class="text-lg font-semibold text-gray-700 mb-4">Lich Sû Ðôn Hàng</h2>
                <div class="bg-gray-50 rounded-lg overflow-hidden">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Mã Đơn</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tổng Tiền</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Trang Thái</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Ngày</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($user->orders->take(5) as $order)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">#{{ $order->id }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${{ number_format($order->total_price, 0) }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            {{ $order->status == 'completed' ? 'bg-green-100 text-green-800' : 
                                               ($order->status == 'cancelled' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
                                            {{ $order->status }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $order->created_at->format('d/m/Y') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @if($user->orders->count() > 5)
                    <div class="mt-4 text-center">
                        <a href="{{ route('admin.orders.index') }}?user_id={{ $user->id }}" class="text-blue-600 hover:text-blue-800">
                            Xem tất cả {{ $user->orders->count() }} Đơn hàng
                        </a>
                    </div>
                @endif
            </div>
        @else
            <div class="mt-8">
                <h2 class="text-lg font-semibold text-gray-700 mb-4">Lich Sû Ðôn Hàng</h2>
                <div class="bg-gray-50 rounded-lg p-8 text-center text-gray-500">
                    Chưa có Đơn hàng nào
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
