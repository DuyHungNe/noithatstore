@extends('layouts.user')

@section('title', 'Đăng nhập')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-orange-50 via-white to-amber-100 py-16 px-4">
    <div class="max-w-6xl mx-auto grid grid-cols-1 lg:grid-cols-2 gap-10 items-center">
        <div class="hidden lg:block">
            <div class="bg-white/80 backdrop-blur rounded-3xl shadow-2xl p-10 border border-orange-100">
                <p class="text-orange-600 font-semibold mb-3">Chào mừng trở lại</p>
                <h1 class="text-4xl font-bold text-gray-900 leading-tight mb-4">Đăng nhập để tiếp tục mua sắm nội thất yêu thích</h1>
                <p class="text-gray-600 mb-6">Quản lý đơn hàng, lưu sản phẩm yêu thích và theo dõi thông tin tài khoản của bạn một cách dễ dàng.</p>
                <div class="grid grid-cols-2 gap-4 text-sm text-gray-700">
                    <div class="bg-orange-50 rounded-2xl p-4">Giao diện đẹp, thân thiện trên mọi thiết bị</div>
                    <div class="bg-orange-50 rounded-2xl p-4">Đăng nhập nhanh, bảo mật hơn</div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-3xl shadow-2xl border border-gray-100 p-8 md:p-10">
            <div class="mb-8 text-center">
                <h2 class="text-3xl font-bold text-gray-900">Đăng nhập</h2>
                <p class="text-gray-500 mt-2">Vui lòng nhập thông tin tài khoản của bạn</p>
            </div>

            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="email"
                        class="w-full rounded-xl border border-gray-300 px-4 py-3 focus:border-orange-500 focus:ring-4 focus:ring-orange-100 outline-none @error('email') border-red-500 @enderror">
                    @error('email')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Mật khẩu</label>
                    <input id="password" type="password" name="password" required autocomplete="current-password"
                        class="w-full rounded-xl border border-gray-300 px-4 py-3 focus:border-orange-500 focus:ring-4 focus:ring-orange-100 outline-none @error('password') border-red-500 @enderror">
                    @error('password')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-between text-sm">
                    <label class="flex items-center gap-2 text-gray-600">
                        <input type="checkbox" name="remember" id="remember" class="rounded border-gray-300 text-orange-600 focus:ring-orange-500" {{ old('remember') ? 'checked' : '' }}>
                        <span>Ghi nhớ đăng nhập</span>
                    </label>

                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-orange-600 hover:text-orange-700 font-medium">Quên mật khẩu?</a>
                    @endif
                </div>

                <button type="submit" class="w-full bg-orange-600 hover:bg-orange-700 text-white font-semibold py-3 rounded-xl transition shadow-lg shadow-orange-200">
                    Đăng nhập
                </button>

                <p class="text-center text-sm text-gray-600">
                    Chưa có tài khoản?
                    <a href="{{ route('register') }}" class="text-orange-600 hover:text-orange-700 font-semibold">Đăng ký ngay</a>
                </p>
            </form>
        </div>
    </div>
</div>
@endsection
