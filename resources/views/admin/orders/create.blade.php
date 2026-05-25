@extends('layouts.admin')

@section('title', 'Tao Don Hang Moi')

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
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Tao Don Hang Moi</h1>

    <form action="{{ route('admin.orders.store') }}" method="POST" class="bg-white shadow rounded-lg p-6">
        @csrf
        
        <div class="mb-6">
            <label for="user_id" class="block text-sm font-medium text-gray-700 mb-2">Khach Hang</label>
            <select name="user_id" id="user_id" required
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">-- Chon Khach Hang --</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                        {{ $user->name }} ({{ $user->email }})
                    </option>
                @endforeach
            </select>
            @error('user_id')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6">
            <h3 class="text-lg font-semibold mb-4">San Pham</h3>
            <div id="productList" class="space-y-4">
                <!-- Product items will be added here dynamically -->
            </div>
            
            <button type="button" onclick="addProduct()" class="mt-4 bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">
                + Them San Pham
            </button>
        </div>

        <div class="mb-6">
            <div class="bg-gray-50 p-4 rounded">
                <div class="flex justify-between items-center">
                    <span class="text-lg font-semibold">Tong Cong:</span>
                    <span id="totalPrice" class="text-2xl font-bold text-green-600">$0</span>
                </div>
            </div>
        </div>

        <div class="flex justify-end space-x-4">
            <a href="{{ route('admin.orders.index') }}" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                Huy
            </a>
            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">
                Tao Don Hang
            </button>
        </div>
    </form>
</div>

<script>
let productIndex = 0;
const products = @json($products->map(function($product) {
    return [
        'id' => $product->id,
        'name' => $product->name,
        'price' => $product->price,
        'stock' => $product->stock
    ];
}));

function addProduct() {
    productIndex++;
    const productList = document.getElementById('productList');
    
    const productDiv = document.createElement('div');
    productDiv.className = 'product-item bg-gray-50 p-4 rounded';
    productDiv.innerHTML = `
        <div class="flex justify-between items-center mb-3">
            <h4 class="font-semibold">San Pham ${productIndex}</h4>
            <button type="button" onclick="removeProduct(this)" class="text-red-500 hover:text-red-700">
                Xoa
            </button>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">San Pham</label>
                <select name="products[${productIndex}][id]" onchange="updatePrice(this)" required
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">-- Chon San Pham --</option>
                    ${products.map(product => 
                        `<option value="${product.id}" data-price="${product.price}" data-stock="${product.stock}">
                            ${product.name} - $${product.price} (Ton kho: ${product.stock})
                        </option>`
                    ).join('')}
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">So Luong</label>
                <input type="number" name="products[${productIndex}][quantity]" min="1" value="1" 
                    onchange="calculateTotal()" required
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Gia</label>
                <input type="text" readonly value="$0" 
                    class="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-100">
            </div>
        </div>
    `;
    
    productList.appendChild(productDiv);
}

function removeProduct(button) {
    button.closest('.product-item').remove();
    calculateTotal();
}

function updatePrice(select) {
    const productDiv = select.closest('.product-item');
    const selectedOption = select.options[select.selectedIndex];
    const price = selectedOption.dataset.price || 0;
    const stock = parseInt(selectedOption.dataset.stock) || 0;
    const quantityInput = productDiv.querySelector('input[type="number"]');
    const priceInput = productDiv.querySelector('input[readonly]');
    
    priceInput.value = '$' + price;
    
    // Validate quantity against stock
    if (parseInt(quantityInput.value) > stock) {
        quantityInput.value = stock;
        quantityInput.max = stock;
    } else {
        quantityInput.max = stock;
    }
    
    calculateTotal();
}

function calculateTotal() {
    let total = 0;
    const productItems = document.querySelectorAll('.product-item');
    
    productItems.forEach(item => {
        const select = item.querySelector('select');
        const quantityInput = item.querySelector('input[type="number"]');
        
        if (select.value && quantityInput.value) {
            const selectedOption = select.options[select.selectedIndex];
            const price = parseFloat(selectedOption.dataset.price) || 0;
            const quantity = parseInt(quantityInput.value) || 0;
            total += price * quantity;
        }
    });
    
    document.getElementById('totalPrice').textContent = '$' + total.toLocaleString();
}

// Add first product by default
document.addEventListener('DOMContentLoaded', function() {
    addProduct();
});
</script>
@endsection
