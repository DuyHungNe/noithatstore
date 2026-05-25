<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        $cartItems = [];
        $subtotal = 0;

        foreach ($cart as $productId => $item) {
            $product = Product::find($productId);
            if (! $product) {
                continue;
            }

            $quantity = (int) $item['quantity'];
            $lineTotal = $product->price * $quantity;
            $subtotal += $lineTotal;

            $cartItems[] = [
                'product' => $product,
                'quantity' => $quantity,
                'line_total' => $lineTotal,
            ];
        }

        return view('cart.index', [
            'cartItems' => $cartItems,
            'subtotal' => $subtotal,
            'shippingFee' => $subtotal > 0 ? 30000 : 0,
            'total' => $subtotal > 0 ? $subtotal + 30000 : 0,
        ]);
    }

    public function add(Request $request, Product $product): RedirectResponse
    {
        if ($product->stock <= 0) {
            return back()->with('error', 'Sản phẩm này hiện đã hết hàng.');
        }

        $validated = $request->validate([
            'quantity' => 'nullable|integer|min:1',
        ]);

        $quantity = (int) ($validated['quantity'] ?? 1);
        $cart = session()->get('cart', []);
        $currentQuantity = (int) ($cart[$product->id]['quantity'] ?? 0);
        $newQuantity = $currentQuantity + $quantity;

        if ($newQuantity > $product->stock) {
            return back()->with('error', 'Số lượng trong giỏ hàng vượt quá tồn kho hiện tại.');
        }

        $cart[$product->id] = [
            'quantity' => $newQuantity,
        ];

        session()->put('cart', $cart);

        return back()->with('success', 'Đã thêm sản phẩm vào giỏ hàng.');
    }

    public function update(Request $request, Product $product): RedirectResponse
    {
        $validated = $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $cart = session()->get('cart', []);

        if (! isset($cart[$product->id])) {
            return redirect()->route('cart.index')->with('error', 'Sản phẩm không tồn tại trong giỏ hàng.');
        }

        if ($validated['quantity'] > $product->stock) {
            return back()->with('error', 'Số lượng vượt quá tồn kho hiện tại.');
        }

        $cart[$product->id]['quantity'] = (int) $validated['quantity'];
        session()->put('cart', $cart);

        return back()->with('success', 'Đã cập nhật giỏ hàng.');
    }

    public function remove(Product $product): RedirectResponse
    {
        $cart = session()->get('cart', []);
        unset($cart[$product->id]);
        session()->put('cart', $cart);

        return back()->with('success', 'Đã xóa sản phẩm khỏi giỏ hàng.');
    }

    public function checkout(Request $request): RedirectResponse
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return back()->with('error', 'Giỏ hàng của bạn đang trống.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:500',
            'note' => 'nullable|string|max:1000',
        ]);

        $items = [];
        $subtotal = 0;

        foreach ($cart as $productId => $item) {
            $product = Product::find($productId);
            if (! $product) {
                continue;
            }

            $quantity = (int) $item['quantity'];
            if ($quantity > $product->stock) {
                return back()->with('error', "Sản phẩm {$product->name} không đủ tồn kho.");
            }

            $items[] = [
                'product' => $product,
                'quantity' => $quantity,
                'price' => $product->price,
            ];

            $subtotal += $product->price * $quantity;
        }

        if (empty($items)) {
            return back()->with('error', 'Giỏ hàng không hợp lệ.');
        }

        $shippingFee = 30000;
        $totalPrice = $subtotal + $shippingFee;
        $user = Auth::user();

        DB::beginTransaction();

        try {
            if ($user) {
                $user->update([
                    'name' => $validated['name'],
                    'phone' => $validated['phone'],
                    'address' => $validated['address'],
                ]);
            }

            $order = Order::create([
                'user_id' => $user?->id,
                'total_price' => $totalPrice,
                'status' => 'pending',
            ]);

            foreach ($items as $item) {
                $order->orderItems()->create([
                    'product_id' => $item['product']->id,
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                ]);

                $item['product']->decrement('stock', $item['quantity']);
            }

            DB::commit();
            session()->forget('cart');
        } catch (\Throwable $e) {
            DB::rollBack();

            return back()->with('error', 'Không thể tạo đơn hàng COD. Vui lòng thử lại.');
        }

        return redirect()->route('orders.index')->with('success', 'Đặt hàng COD thành công. Chúng tôi sẽ liên hệ xác nhận sớm nhất.');
    }
}
