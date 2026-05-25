<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Nội Thất Store') - Cửa hàng nội thất cao cấp</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">
    <nav class="bg-white shadow-lg sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="/" class="text-2xl font-bold text-orange-600">Nội Thất Store</a>
                </div>
                <div class="hidden md:flex items-center space-x-8">
                    <a href="/" class="text-gray-700 hover:text-orange-600 transition">Trang chủ</a>
                    <a href="/products" class="text-gray-700 hover:text-orange-600 transition">Sản phẩm</a>
                    <a href="/cart" class="text-gray-700 hover:text-orange-600 transition">Giỏ hàng</a>
                    <a href="/categories" class="text-gray-700 hover:text-orange-600 transition">Danh mục</a>
                    <a href="/contact" class="text-gray-700 hover:text-orange-600 transition">Liên hệ</a>
                </div>
                <div class="flex items-center space-x-4">
                    @guest
                        <a href="/login" class="text-gray-700 hover:text-orange-600 transition">Đăng nhập</a>
                        <a href="/register" class="bg-orange-600 text-white px-4 py-2 rounded-lg hover:bg-orange-700 transition">Đăng ký</a>
                    @else
                        <div class="relative group py-2">
                            <button class="flex items-center space-x-2 text-gray-700 hover:text-orange-600 transition px-2 py-2 rounded-md hover:bg-orange-50">
                                <span>{{ Auth::user()->name }}</span>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                            <div class="absolute right-0 top-full mt-1 w-52 bg-white rounded-lg shadow-lg py-2 opacity-0 invisible translate-y-1 group-hover:opacity-100 group-hover:visible group-hover:translate-y-0 transition-all duration-200">
                                <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Hồ sơ</a>
                                <a href="{{ route('orders.index') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Đơn hàng</a>
                                @if(Auth::user()->role === 'admin')
                                    <a href="/admin" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Quản lý</a>
                                @endif
                                <form action="/logout" method="POST" class="border-t mt-1 pt-1">
                                    @csrf
                                    <button type="submit" class="block w-full text-left px-4 py-2 text-gray-700 hover:bg-gray-100">Đăng xuất</button>
                                </form>
                            </div>
                        </div>
                    @endguest
                </div>
            </div>
        </div>
    </nav>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mx-4 mt-4">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mx-4 mt-4">
            {{ session('error') }}
        </div>
    @endif

    <main>
        @yield('content')
    </main>

    <footer class="bg-slate-900 text-white mt-12 border-t border-slate-700">
        <div class="max-w-7xl mx-auto px-4 py-12">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-10 items-start">
                <div class="space-y-3">
                    <h3 class="text-xl font-bold text-orange-400 leading-tight">Nội Thất Store</h3>
                    <p class="text-slate-300 leading-7 max-w-sm">
                        Chuyên cung cấp các sản phẩm nội thất cao cấp, chất lượng cao cho không gian sống của bạn.
                    </p>
                </div>
                <div class="space-y-3 md:justify-self-center">
                    <h3 class="text-xl font-bold text-orange-400 leading-tight">Liên kết</h3>
                    <ul class="space-y-2 text-slate-300">
                        <li><a href="/" class="hover:text-orange-400 transition">Trang chủ</a></li>
                        <li><a href="/products" class="hover:text-orange-400 transition">Sản phẩm</a></li>
                        <li><a href="/cart" class="hover:text-orange-400 transition">Giỏ hàng</a></li>
                        <li><a href="/contact" class="hover:text-orange-400 transition">Liên hệ</a></li>
                    </ul>
                </div>
                <div class="space-y-3 md:justify-self-end">
                    <h3 class="text-xl font-bold text-orange-400 leading-tight">Thông tin liên hệ</h3>
                    <div class="space-y-2 text-slate-300 leading-7">
                        <p>Địa chỉ: Đường Trịnh Văn Bô, Hà Nội</p>
                        <p>Điện thoại: (028) 1234-5678</p>
                        <p>Email: info@noithatstore.vn</p>
                    </div>
                </div>
            </div>

            <div class="mt-10 pt-6 border-t border-slate-700 text-center">
                <p class="text-slate-400 text-sm">&copy; 2026 Nội Thất Store. Bảo lưu mọi quyền.</p>
            </div>
        </div>
    </footer>
</body>
</html>
