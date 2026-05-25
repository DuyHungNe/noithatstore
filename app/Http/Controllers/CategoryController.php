<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::withCount('products')->paginate(10);
        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100|unique:categories,name',
            'description' => 'nullable|string',
            'image' => 'required|image|mimes:jpeg,jpg,png,gif,webp|max:2048',
            'is_active' => 'boolean'
        ], [
            'image.required' => 'Vui lòng chon hinh anh',
            'image.image' => 'File duoc chon khong phai la hinh anh',
            'image.mimes' => 'Hinh anh phai co dinh dang: jpeg, jpg, png, gif, webp',
            'image.max' => 'Kich thuoc hinh anh khong duoc vuot qua 2MB'
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        $validated['is_active'] = $request->has('is_active');

        // Handle image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            
            // Standardized path: use public_path for consistency
            $uploadPath = public_path('uploads/categories');
            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }
            
            try {
                $image->move($uploadPath, $imageName);
                $validated['image'] = 'uploads/categories/' . $imageName;
            } catch (\Exception $e) {
                return redirect()->back()
                    ->with('error', 'Loi khi upload anh: ' . $e->getMessage())
                    ->withInput();
            }
        }

        Category::create($validated);
        
        return redirect()->route('admin.categories.index')
            ->with('success', 'Danh muc da duoc tao thanh cong.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        $category->load('products');
        return view('admin.categories.show', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100|unique:categories,name,' . $category->id,
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,jpg,png,gif,webp|max:2048',
            'is_active' => 'boolean'
        ], [
            'image.image' => 'File duoc chon khong phai la hinh anh',
            'image.mimes' => 'Hinh anh phai co dinh dang: jpeg, jpg, png, gif, webp',
            'image.max' => 'Kich thuoc hinh anh khong duoc vuot qua 2MB'
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        $validated['is_active'] = $request->has('is_active');

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image
            if ($category->image && !str_contains($category->image, 'http')) {
                $oldImagePath = public_path($category->image);
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }

            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            
            // Standardized path: use public_path for consistency
            $uploadPath = public_path('uploads/categories');
            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }
            
            try {
                $image->move($uploadPath, $imageName);
                $validated['image'] = 'uploads/categories/' . $imageName;
            } catch (\Exception $e) {
                return redirect()->back()
                    ->with('error', 'Loi khi upload anh: ' . $e->getMessage())
                    ->withInput();
            }
        }

        $category->update($validated);
        
        return redirect()->route('admin.categories.index')
            ->with('success', 'Danh muc da duoc cap nhat thanh cong.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        if ($category->products()->count() > 0) {
            return redirect()->route('admin.categories.index')
                ->with('error', 'Không thể xóa danh mục đang có sản phẩm.');
        }

        // Delete image file
        if ($category->image && !str_contains($category->image, 'http')) {
            $imagePath = public_path($category->image);
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }

        $category->delete();
        
        return redirect()->route('admin.categories.index')
            ->with('success', 'Danh mục đã được xóa thành công.');
    }
}
