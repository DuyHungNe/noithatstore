<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Nôi Thât Store') - Cây hàng nôi thât cao câp</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-white shadow-lg sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="/" class="text-2xl font-bold text-orange-600">Nôi Thât Store</a>
                </div>
                <div class="hidden md:flex items-center space-x-8">
                    <a href="/" class="text-gray-700 hover:text-orange-600 transition">Trang Chû</a>
                    <a href="/products" class="text-gray-700 hover:text-orange-600 transition">Sân Phâm</a>
                    <a href="/categories" class="text-gray-700 hover:text-orange-600 transition">Danh Muc</a>
                    <a href="/contact" class="text-gray-700 hover:text-orange-600 transition">Liên Hê</a>
                </div>
                <div class="flex items-center space-x-4">
                    @guest
                        <a href="/login" class="text-gray-700 hover:text-orange-600 transition">Ðâng Nhâp</a>
                        <a href="/register" class="bg-orange-600 text-white px-4 py-2 rounded-lg hover:bg-orange-700 transition">Ðâng Ký</a>
                    @else
                        <div class="relative group">
                            <button class="flex items-center space-x-2 text-gray-700 hover:text-orange-600 transition">
                                <span>{{ Auth::user()->name }}</span>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                            <div class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg py-2 hidden group-hover:block">
                                <a href="/profile" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Hô Sô</a>
                                <a href="/orders" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Ðôn Hàng</a>
                                @if(Auth::user()->role === 'admin')
                                    <a href="/admin" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Quân Lý</a>
                                @endif
                                <form action="/logout" method="POST" class="border-t">
                                    @csrf
                                    <button type="submit" class="block w-full text-left px-4 py-2 text-gray-700 hover:bg-gray-100">Ðâng Xuât</button>
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
                    <h3 class="text-xl font-bold mb-4 text-orange-400">Nôi Thât Store</h3>
                    <p class="text-gray-300">Chuyên cung câp các sân phâm nôi thât cao câp, chât luong cao cho không gian sông cûa ban.</p>
                </div>
                <div>
                    <h3 class="text-xl font-bold mb-4 text-orange-400">Liên Kêt</h3>
                    <ul class="space-y-2">
                        <li><a href="/" class="text-gray-300 hover:text-orange-400">Trang Chû</a></li>
                        <li><a href="/products" class="text-gray-300 hover:text-orange-400">Sân Phâm</a></li>
                        <li><a href="/contact" class="text-gray-300 hover:text-orange-400">Liên Hê</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-xl font-bold mb-4 text-orange-400">Thông Tin Liên Hê</h3>
                    <p class="text-gray-300">Ðiâ chi: 123 Nguyën Vãn Linh, Quân 7, TP.HCM</p>
                    <p class="text-gray-300">Ðiên thoai: (028) 1234-5678</p>
                    <p class="text-gray-300">Email: info@noithatstore.vn</p>
                </div>
            </div>
            <div class="border-t border-gray-700 mt-8 pt-8 text-center">
                <p class="text-gray-400">&copy; 2026 Nôi Thât Store. All rights reserved.</p>
            </div>
        </div>
    </footer>
</body>
</html>
