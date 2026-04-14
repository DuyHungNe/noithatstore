<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::paginate(10);
        return view('admin.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.products.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'required|file|image|max:2048'
        ], [
            'image.required' => 'Vui lòng chọn hình ảnh sản phẩm',
            'image.file' => 'File được chọn không hợp lệ',
            'image.image' => 'File được chọn không phải là hình ảnh',
            'image.max' => 'Kích thước file quá lớn. Vui lòng chọn file nhỏ hơn 2MB'
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            
            // Debug information
            \Log::info('Product image upload details:', [
                'original_name' => $image->getClientOriginalName(),
                'mime_type' => $image->getMimeType(),
                'size' => $image->getSize(),
                'extension' => $image->getClientOriginalExtension(),
                'is_valid' => $image->isValid(),
                'error' => $image->getError()
            ]);
            
            if ($image->isValid()) {
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                
                try {
                    $image->move(storage_path('app/public/uploads/products'), $imageName);
                    $validated['image'] = 'uploads/products/' . $imageName;
                    
                    \Log::info('Product image uploaded successfully:', [
                        'filename' => $imageName,
                        'path' => 'uploads/products/' . $imageName
                    ]);
                } catch (\Exception $e) {
                    \Log::error('Failed to move uploaded product image:', [
                        'error' => $e->getMessage(),
                        'temp_path' => $image->getPathname()
                    ]);
                    
                    return redirect()->back()
                        ->with('error', 'Lỗi khi upload ảnh sản phẩm: ' . $e->getMessage())
                        ->withInput();
                }
            } else {
                \Log::error('Invalid product image file:', [
                    'error' => $image->getError(),
                    'mime_type' => $image->getMimeType()
                ]);
                
                return redirect()->back()
                    ->with('error', 'File ảnh sản phẩm không hợp lệ: ' . $image->getError())
                    ->withInput();
            }
        }

        Product::create($validated);
        
        return redirect()->route('admin.products.index')
            ->with('success', 'Product created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return view('admin.products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        return view('admin.products.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|file|image|mimes:jpeg,jpg,png,gif,webp|max:2048'
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image
            if ($product->image && !str_contains($product->image, 'http')) {
                $oldImagePath = public_path($product->image);
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }

            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/products'), $imageName);
            $validated['image'] = 'uploads/products/' . $imageName;
        }

        $product->update($validated);
        
        return redirect()->route('admin.products.index')
            ->with('success', 'Product updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();
        
        return redirect()->route('admin.products.index')
            ->with('success', 'Product deleted successfully.');
    }
}
