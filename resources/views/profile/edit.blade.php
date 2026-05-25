@extends('layouts.user')

@section('title', 'Hồ sơ')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-10">
    <div class="bg-white rounded-xl shadow p-8">
        <h1 class="text-3xl font-bold mb-6">Hồ sơ của tôi</h1>

        <form action="{{ route('profile.update') }}" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @csrf
            @method('PUT')
            <input type="text" name="name" value="{{ old('name', $user->name) }}" class="px-4 py-2 border rounded-lg" placeholder="Họ tên">
            <input type="email" name="email" value="{{ old('email', $user->email) }}" class="px-4 py-2 border rounded-lg" placeholder="Email">
            <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" class="px-4 py-2 border rounded-lg md:col-span-2" placeholder="Số điện thoại">
            <textarea name="address" rows="4" class="px-4 py-2 border rounded-lg md:col-span-2" placeholder="Địa chỉ">{{ old('address', $user->address) }}</textarea>
            <div class="md:col-span-2">
                <button class="bg-orange-600 text-white px-6 py-3 rounded-lg hover:bg-orange-700">Cập nhật hồ sơ</button>
            </div>
        </form>
    </div>
</div>
@endsection
