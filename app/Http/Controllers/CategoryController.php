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
        // Temporarily disable image validation to debug
        $validated = $request->validate([
            'name' => 'required|string|max:100|unique:categories,name',
            'description' => 'nullable|string',
            'is_active' => 'boolean'
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        $validated['is_active'] = $request->has('is_active');

        // Manual image validation and upload
        if (!$request->hasFile('image')) {
            return redirect()->back()
                ->with('error', 'Vui lòng choosing hình')
                ->withInput();
        }

        $image = $request->file('image');
        
        // Debug information
        \Log::info('Image upload details:', [
            'original_name' => $image->getClientOriginalName(),
            'mime_type' => $image->getMimeType(),
            'size' => $image->getSize(),
            'extension' => $image->getClientOriginalExtension(),
            'is_valid' => $image->isValid(),
            'error' => $image->getError(),
            'tmp_name' => $image->getPathname()
        ]);
        
        if (!$image->isValid()) {
            \Log::error('Invalid image file:', [
                'error' => $image->getError(),
                'mime_type' => $image->getMimeType(),
                'tmp_name' => $image->getPathname(),
                'file_exists' => file_exists($image->getPathname())
            ]);
            
            return redirect()->back()
                ->with('error', 'File không: ' . $image->getError() . ' (MIME: ' . $image->getMimeType() . ')')
                ->withInput();
        }
        
        // Check file size
        if ($image->getSize() > 2048 * 1024) {
            return redirect()->back()
                ->with('error', 'Kích th')
                ->withInput();
        }
        
        // Check if it's actually an image
        $allowedMimes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/webp'];
        if (!in_array($image->getMimeType(), $allowedMimes)) {
            return redirect()->back()
                ->with('error', 'File không: ' . $image->getMimeType())
                ->withInput();
        }
        
        // Handle image upload
        {
            \Log::info('Image upload details:', [
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
                    $image->move(storage_path('app/public/uploads/categories'), $imageName);
                    $validated['image'] = 'uploads/categories/' . $imageName;
                    
                    \Log::info('Image uploaded successfully:', [
                        'filename' => $imageName,
                        'path' => 'uploads/categories/' . $imageName
                    ]);
                } catch (\Exception $e) {
                    \Log::error('Failed to move uploaded image:', [
                        'error' => $e->getMessage(),
                        'temp_path' => $image->getPathname()
                    ]);
                    
                    return redirect()->back()
                        ->with('error', 'Lỗi khi upload ảnh: ' . $e->getMessage())
                        ->withInput();
                }
            } else {
                \Log::error('Invalid image file:', [
                    'error' => $image->getError(),
                    'mime_type' => $image->getMimeType()
                ]);
                
                return redirect()->back()
                    ->with('error', 'File ảnh không hợp lệ: ' . $image->getError())
                    ->withInput();
            }
        }

        Category::create($validated);
        
        return redirect()->route('admin.categories.index')
            ->with('success', 'Category created successfully.');
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
            'image' => 'nullable|image|mimes:jpeg,jpg,png,gif|max:2048',
            'is_active' => 'boolean'
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
            $image->move(public_path('uploads/categories'), $imageName);
            $validated['image'] = 'uploads/categories/' . $imageName;
        }

        $category->update($validated);
        
        return redirect()->route('admin.categories.index')
            ->with('success', 'Category updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        if ($category->products()->count() > 0) {
            return redirect()->route('admin.categories.index')
                ->with('error', 'Cannot delete category with products.');
        }

        $category->delete();
        
        return redirect()->route('admin.categories.index')
            ->with('success', 'Category deleted successfully.');
    }
}
