<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = Order::with('user', 'products')->paginate(10);
        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::all();
        $products = Product::all();
        return view('admin.orders.create', compact('users', 'products'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'products' => 'required|array',
            'products.*.id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1'
        ]);

        // Validate stock and calculate total price
        $totalPrice = 0;
        foreach ($validated['products'] as $productData) {
            $product = Product::find($productData['id']);
            
            // Check stock availability
            if ($product->stock < $productData['quantity']) {
                return redirect()->back()
                    ->with('error', "Sản phẩm '{$product->name}' chỉ còn {$product->stock} trong kho, không đủ để đặt hàng.")
                    ->withInput();
            }
            
            // Use current product price
            $price = $product->price;
            $totalPrice += $productData['quantity'] * $price;
            
            // Store price for order item
            $validated['products'][$productData['id']]['price'] = $price;
        }

        // Create order with transaction
        \DB::beginTransaction();
        try {
            $order = Order::create([
                'user_id' => $validated['user_id'],
                'total_price' => $totalPrice,
                'status' => 'pending'
            ]);

            foreach ($validated['products'] as $productData) {
                // Create order item
                $order->orderItems()->create([
                    'product_id' => $productData['id'],
                    'quantity' => $productData['quantity'],
                    'price' => $validated['products'][$productData['id']]['price']
                ]);
                
                // Update product stock
                $product = Product::find($productData['id']);
                $product->decrement('stock', $productData['quantity']);
            }
            
            \DB::commit();
        } catch (\Exception $e) {
            \DB::rollback();
            
            return redirect()->back()
                ->with('error', 'Lỗi khi tạo đơn hàng: ' . $e->getMessage())
                ->withInput();
        }
        
        return redirect()->route('admin.orders.index')
            ->with('success', 'Đơn hàng đã được tạo thành công.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        $order->load(['user', 'orderItems.product']);
        return view('admin.orders.show', compact('order'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        $order->load(['user', 'orderItems.product']);
        return view('admin.orders.edit', compact('order'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,completed,cancelled'
        ]);

        $order->update($validated);
        
        return redirect()->route('admin.orders.index')
            ->with('success', 'Đơn hàng đã được cập nhật thành công.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        // Restore stock if order is not cancelled
        if ($order->status !== 'cancelled') {
            foreach ($order->orderItems as $item) {
                $item->product->increment('stock', $item->quantity);
            }
        }

        $order->delete();
        
        return redirect()->route('admin.orders.index')
            ->with('success', 'Đơn hàng đã được xóa thành công.');
    }
}
