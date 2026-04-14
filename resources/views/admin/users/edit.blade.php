@extends('layouts.admin')

@section('title', 'Sûa Thông Tin Ngôi Dùng')

@section('content')
<div class="max-w-2xl mx-auto">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Sûa Thông Tin Ngôi Dùng</h1>

    <form action="{{ route('admin.users.update', $user) }}" method="POST" class="bg-white shadow rounded-lg p-6">
        @csrf
        @method('PUT')
        
        <div class="mb-4">
            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Hô và Tên</label>
            <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" required
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            @error('name')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
            <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" required
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            @error('email')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Mât Khâu Môi</label>
            <input type="password" name="password" id="password"
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                placeholder="De trông nêu không thay dôi">
            @error('password')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
            <p class="text-xs text-gray-500 mt-1">De trông nêu không muôn dôi mât khâu</p>
        </div>

        <div class="mb-4">
            <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">Ðiên Thoai</label>
            <input type="tel" name="phone" id="phone" value="{{ old('phone', $user->phone) }}"
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            @error('phone')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="address" class="block text-sm font-medium text-gray-700 mb-2">Ðiâ Chi</label>
            <textarea name="address" id="address" rows="3"
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('address', $user->address) }}</textarea>
            @error('address')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6">
            <label for="role" class="block text-sm font-medium text-gray-700 mb-2">Vai Trò</label>
            <select name="role" id="role" required
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="user" {{ old('role', $user->role) == 'user' ? 'selected' : '' }}>User</option>
                <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
            </select>
            @error('role')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex justify-end space-x-4">
            <a href="{{ route('admin.users.index') }}" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                Hûy
            </a>
            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">
                Câp Nhât
            </button>
        </div>
    </form>
</div>
@endsection
