<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Nội Thất Store') - Cửa hàng nội thất cao cấp</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-white shadow-lg sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="/" class="text-2xl font-bold text-orange-600">Nội Thất Store</a>
                </div>
                <div class="hidden md:flex items-center space-x-8">
                    <a href="/" class="text-gray-700 hover:text-orange-600 transition">Trang chủ</a>
                    <a href="/products" class="text-gray-700 hover:text-orange-600 transition">Sản phẩm</a>
                    <a href="/categories" class="text-gray-700 hover:text-orange-600 transition">Danh mục</a>
                    <a href="/contact" class="text-gray-700 hover:text-orange-600 transition">Liên hệ</a>
                </div>
                <div class="flex items-center space-x-4">
                    @guest
                        <a href="/login" class="text-gray-700 hover:text-orange-600 transition">Đăng nhập</a>
                        <a href="/register" class="bg-orange-600 text-white px-4 py-2 rounded-lg hover:bg-orange-700 transition">Đăng ký</a>
                    @else
                        <div class="relative group">
                            <button class="flex items-center space-x-2 text-gray-700 hover:text-orange-600 transition">
                                <span>{{ Auth::user()->name }}</span>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                            <div class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg py-2 hidden group-hover:block">
                                <a href="/profile" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Hồ sơ</a>
                                <a href="/orders" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Đơn hàng</a>
                                @if(Auth::user()->role === 'admin')
                                    <a href="/admin" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Quản lý</a>
                                @endif
                                <form action="/logout" method="POST" class="border-t">
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

    <!-- Messages -->
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

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white mt-12">
        <div class="max-w-7xl mx-auto px-4 py-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div>
                    <h3 class="text-xl font-bold mb-4 text-orange-400">Nội Thất Store</h3>
                    <p class="text-gray-300">Chuyên cung cấp các sản phẩm nội thất cao cấp, chất lượng cao cho không gian sống của bạn.</p>
                </div>
                <div>
                    <h3 class="text-xl font-bold mb-4 text-orange-400">Liên kết</h3>
                    <ul class="space-y-2">
                        <li><a href="/" class="text-gray-300 hover:text-orange-400">Trang chủ</a></li>
                        <li><a href="/products" class="text-gray-300 hover:text-orange-400">Sản phẩm</a></li>
                        <li><a href="/contact" class="text-gray-300 hover:text-orange-400">Liên hệ</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-xl font-bold mb-4 text-orange-400">Thông tin liên hệ</h3>
                    <p class="text-gray-300">Địa chỉ:Đường Trịnh Văn Bô, Hà Nội</p>
                    <p class="text-gray-300">Điện thoại: (028) 1234-5678</p>
                    <p class="text-gray-300">Email: info@noithatstore.vn</p>
                </div>
            </div>
            <div class="border-t border-gray-700 mt-8 pt-8 text-center">
                <p class="text-gray-400">&copy; 2026 Nội Thất Store. Bảo lưu mọi quyền.</p>
            </div>
        </div>
    </footer>
</body>
</html>
