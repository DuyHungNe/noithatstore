@extends('layouts.user')

@section('title', 'Đăng ký')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-orange-50 via-white to-amber-100 py-16 px-4">
    <div class="max-w-6xl mx-auto grid grid-cols-1 lg:grid-cols-2 gap-10 items-center">
        <div class="hidden lg:block order-2 lg:order-1">
            <div class="bg-white/80 backdrop-blur rounded-3xl shadow-2xl p-10 border border-orange-100">
                <p class="text-orange-600 font-semibold mb-3">Tạo tài khoản mới</p>
                <h1 class="text-4xl font-bold text-gray-900 leading-tight mb-4">Tham gia để trải nghiệm mua sắm nội thất dễ dàng hơn</h1>
                <p class="text-gray-600 mb-6">Tạo tài khoản để theo dõi đơn hàng, quản lý thông tin cá nhân và nhận ưu đãi sớm nhất.</p>
                <div class="grid grid-cols-2 gap-4 text-sm text-gray-700">
                    <div class="bg-orange-50 rounded-2xl p-4">Đăng ký nhanh chóng</div>
                    <div class="bg-orange-50 rounded-2xl p-4">Quản lý đơn hàng thuận tiện</div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-3xl shadow-2xl border border-gray-100 p-8 md:p-10 order-1 lg:order-2">
            <div class="mb-8 text-center">
                <h2 class="text-3xl font-bold text-gray-900">Đăng ký</h2>
                <p class="text-gray-500 mt-2">Tạo tài khoản mới để bắt đầu</p>
            </div>

            <form method="POST" action="{{ route('register') }}" class="space-y-5">
                @csrf

                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Họ và tên</label>
                    <input id="name" type="text" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus
                        class="w-full rounded-xl border border-gray-300 px-4 py-3 focus:border-orange-500 focus:ring-4 focus:ring-orange-100 outline-none @error('name') border-red-500 @enderror">
                    @error('name')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="email"
                        class="w-full rounded-xl border border-gray-300 px-4 py-3 focus:border-orange-500 focus:ring-4 focus:ring-orange-100 outline-none @error('email') border-red-500 @enderror">
                    @error('email')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Mật khẩu</label>
                    <input id="password" type="password" name="password" required autocomplete="new-password"
                        class="w-full rounded-xl border border-gray-300 px-4 py-3 focus:border-orange-500 focus:ring-4 focus:ring-orange-100 outline-none @error('password') border-red-500 @enderror">
                    @error('password')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password-confirm" class="block text-sm font-medium text-gray-700 mb-2">Xác nhận mật khẩu</label>
                    <input id="password-confirm" type="password" name="password_confirmation" required autocomplete="new-password"
                        class="w-full rounded-xl border border-gray-300 px-4 py-3 focus:border-orange-500 focus:ring-4 focus:ring-orange-100 outline-none">
                </div>

                <button type="submit" class="w-full bg-orange-600 hover:bg-orange-700 text-white font-semibold py-3 rounded-xl transition shadow-lg shadow-orange-200">
                    Đăng ký
                </button>

                <p class="text-center text-sm text-gray-600">
                    Đã có tài khoản?
                    <a href="{{ route('login') }}" class="text-orange-600 hover:text-orange-700 font-semibold">Đăng nhập</a>
                </p>
            </form>
        </div>
    </div>
</div>
@endsection
