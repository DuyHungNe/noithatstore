<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::with('images')->paginate(10);
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
            'category_id' => 'required|exists:categories,id',
            'image' => 'required|image|mimes:jpeg,jpg,png,gif,webp|max:2048',
            'gallery_images' => 'nullable|array',
            'gallery_images.*' => 'image|mimes:jpeg,jpg,png,gif,webp|max:2048',
        ], [
            'image.required' => 'Vui lòng chọn ảnh chính của sản phẩm',
            'image.image' => 'File được chọn không phải là hình ảnh',
            'image.mimes' => 'Ảnh phải có định dạng: jpeg, jpg, png, gif, webp',
            'image.max' => 'Kích thước ảnh không được vượt quá 2MB',
            'gallery_images.*.image' => 'Một trong các ảnh phụ không phải là hình ảnh',
            'gallery_images.*.mimes' => 'Ảnh phụ phải có định dạng: jpeg, jpg, png, gif, webp',
            'gallery_images.*.max' => 'Kích thước ảnh phụ không được vượt quá 2MB',
            'category_id.required' => 'Vui lòng chọn danh mục',
            'category_id.exists' => 'Danh mục được chọn không tồn tại'
        ]);

        DB::transaction(function () use ($request, &$validated) {
            $validated['image'] = $this->uploadProductImage($request->file('image'));
            $product = Product::create($validated);

            foreach ((array) $request->file('gallery_images') as $index => $galleryImage) {
                if (!$galleryImage) {
                    continue;
                }

                ProductImage::create([
                    'product_id' => $product->id,
                    'path' => $this->uploadProductImage($galleryImage),
                    'is_primary' => false,
                ]);
            }
        });
        
        return redirect()->route('admin.products.index')
            ->with('success', 'Sản phẩm đã được tạo thành công.');
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
        $product->load('images');
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
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|file|image|mimes:jpeg,jpg,png,gif,webp|max:2048',
            'gallery_images' => 'nullable|array',
            'gallery_images.*' => 'image|mimes:jpeg,jpg,png,gif,webp|max:2048',
        ], [
            'gallery_images.*.image' => 'Một trong các ảnh phụ không phải là hình ảnh',
            'gallery_images.*.mimes' => 'Ảnh phụ phải có định dạng: jpeg, jpg, png, gif, webp',
            'gallery_images.*.max' => 'Kích thước ảnh phụ không được vượt quá 2MB',
        ]);

        DB::transaction(function () use ($request, $product, $validated) {
            if ($request->hasFile('image')) {
                if ($product->image && !str_contains($product->image, 'http')) {
                    $oldImagePath = public_path($product->image);
                    if (file_exists($oldImagePath)) {
                        unlink($oldImagePath);
                    }
                }
                $validated['image'] = $this->uploadProductImage($request->file('image'));
            }

            $product->update($validated);

            if ($request->hasFile('gallery_images')) {
                foreach ($product->images()->where('is_primary', false)->get() as $existingImage) {
                    $existingPath = public_path($existingImage->path);
                    if (file_exists($existingPath)) {
                        unlink($existingPath);
                    }
                    $existingImage->delete();
                }

                foreach ((array) $request->file('gallery_images') as $galleryImage) {
                    if (!$galleryImage) {
                        continue;
                    }

                    ProductImage::create([
                        'product_id' => $product->id,
                        'path' => $this->uploadProductImage($galleryImage),
                        'is_primary' => false,
                    ]);
                }
            }
        });
        
        return redirect()->route('admin.products.index')
            ->with('success', 'Sản phẩm đã được cập nhật thành công.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        if ($product->image && !str_contains($product->image, 'http')) {
            $imagePath = public_path($product->image);
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }

        foreach ($product->images as $image) {
            $imagePath = public_path($image->path);
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }

        $product->delete();
        
        return redirect()->route('admin.products.index')
            ->with('success', 'Sản phẩm đã được xóa thành công.');
    }

    private function uploadProductImage($image): string
    {
        $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
        $uploadPath = public_path('uploads/products');

        if (!file_exists($uploadPath)) {
            mkdir($uploadPath, 0755, true);
        }

        $image->move($uploadPath, $imageName);

        return 'uploads/products/' . $imageName;
    }
}
