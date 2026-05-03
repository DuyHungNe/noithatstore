@extends('layouts.user')

@section('title', 'Vê Chúng Tôi')

@section('content')
<!-- Hero Section -->
<section class="bg-gradient-to-r from-orange-500 to-orange-600 text-white py-16">
    <div class="max-w-7xl mx-auto px-4 text-center">
        <h1 class="text-4xl md:text-5xl font-bold mb-4">Vê Nôi Thât Store</h1>
        <p class="text-xl max-w-3xl mx-auto">Hân hanh là nhà cung câp nôi thât cao câp hâng dâu Viêt Nam vôi hon 15 nâm kinh nghiêm</p>
    </div>
</section>

<!-- About Content -->
<section class="py-16">
    <div class="max-w-7xl mx-auto px-4">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div>
                <h2 class="text-3xl font-bold text-gray-900 mb-6">Câu Chuyên Cûa Chúng Tôi</h2>
                <p class="text-gray-600 mb-6 leading-relaxed">
                    Duoc thành lâp vào nâm 2010, Nôi Thât Store tiêp tuc sâng mâng các sân phâm nôi thât cao câp, mang lai không gian sông thoãi mái và sang trong cho khách hàng.
                </p>
                <p class="text-gray-600 mb-6 leading-relaxed">
                    Vôi sâng mâng kinh nghiêm và tâm huyêt, chúng tôi cam kêan mang den cho khách hàng nhûng sân phâm chât luong nhât, thiêt kê hiên dai và phù hûp vôi không gian sông cûa nguôi Viêt.
                </p>
                <div class="grid grid-cols-2 gap-6">
                    <div>
                        <h3 class="text-3xl font-bold text-orange-600 mb-2">15+</h3>
                        <p class="text-gray-600">Nâm kinh nghiêm</p>
                    </div>
                    <div>
                        <h3 class="text-3xl font-bold text-orange-600 mb-2">5000+</h3>
                        <p class="text-gray-600">Khách hàng tin tûng</p>
                    </div>
                </div>
            </div>
            <div>
                <img src="https://via.placeholder.com/600x400/FF6B35/FFFFFF?text=Nôi+Thât+Store" alt="Vê chúng tôi" class="rounded-lg shadow-lg">
            </div>
        </div>
    </div>
</section>

<!-- Values Section -->
<section class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4">
        <h2 class="text-3xl font-bold text-center text-gray-900 mb-12">Giá Trî Cût Lõi</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="text-center">
                <div class="w-20 h-20 bg-orange-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-10 h-10 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold mb-4">Chât Luong Ðâm Bâo</h3>
                <p class="text-gray-600">Tât ca sân phâm duoc chon loc ky luong, cam kêan chât luong và bào hành dài hân.</p>
            </div>
            <div class="text-center">
                <div class="w-20 h-20 bg-orange-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-10 h-10 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold mb-4">Dich Vû Tôt Nhât</h3>
                <p class="text-gray-600">Dôi nguôi chuyên nghiêp, tuvân tâm huyêt và hô trô nhanh chóng cho khách hàng.</p>
            </div>
            <div class="text-center">
                <div class="w-20 h-20 bg-orange-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-10 h-10 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold mb-4">Khách Hàng Là Trên Hêt</h3>
                <p class="text-gray-600">Luôn lâng nghe và dáp úng nhu câu cûa khách hàng vôi các sân phâm tôt nhât.</p>
            </div>
        </div>
    </div>
</section>

<!-- Team Section -->
<section class="py-16">
    <div class="max-w-7xl mx-auto px-4">
        <h2 class="text-3xl font-bold text-center text-gray-900 mb-12">Dôi Ngû Cûa Chúng Tôi</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="text-center">
                <div class="w-32 h-32 bg-gray-200 rounded-full mx-auto mb-4 flex items-center justify-center">
                    <span class="text-gray-500 text-lg">CEO</span>
                </div>
                <h3 class="text-xl font-semibold mb-2">Nguyên Vãn A</h3>
                <p class="text-gray-600">Nhâ sâng lâp & CEO</p>
            </div>
            <div class="text-center">
                <div class="w-32 h-32 bg-gray-200 rounded-full mx-auto mb-4 flex items-center justify-center">
                    <span class="text-gray-500 text-lg">Designer</span>
                </div>
                <h3 class="text-xl font-semibold mb-2">Trân Thî B</h3>
                <p class="text-gray-600">Trû phòng thiêt kê</p>
            </div>
            <div class="text-center">
                <div class="w-32 h-32 bg-gray-200 rounded-full mx-auto mb-4 flex items-center justify-center">
                    <span class="text-gray-500 text-lg">Manager</span>
                </div>
                <h3 class="text-xl font-semibold mb-2">Lê Vãn C</h3>
                <p class="text-gray-600">Trû phòng kinh doanh</p>
            </div>
        </div>
    </div>
</section>
@endsection
