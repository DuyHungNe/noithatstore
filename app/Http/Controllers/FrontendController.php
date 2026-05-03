<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class FrontendController extends Controller
{
    public function home()
    {
        $featuredProducts = Product::with('category')->where('stock', '>', 0)->take(8)->get();
        $categories = Category::where('is_active', true)->take(6)->get();
        
        return view('frontend.home', compact('featuredProducts', 'categories'));
    }

    public function products(Request $request)
    {
        $query = Product::with('category')->where('stock', '>', 0);
        
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }
        
        if ($request->filled('search')) {
            $search = trim($request->search);
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('description', 'like', '%' . $search . '%')
                  ->orWhereHas('category', function ($categoryQuery) use ($search) {
                      $categoryQuery->where('name', 'like', '%' . $search . '%');
                  });
            });
        }
        
        $products = $query->paginate(12)->appends($request->query());
        $categories = Category::where('is_active', true)->get();
        
        return view('frontend.products', compact('products', 'categories'));
    }

    public function productDetail($id)
    {
        $product = Product::with(['category', 'images' => function ($query) {
            $query->orderByDesc('is_primary')->orderBy('id');
        }])->findOrFail($id);

        $relatedProducts = Product::with('category')
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('stock', '>', 0)
            ->take(4)
            ->get();
        
        return view('frontend.product-detail', compact('product', 'relatedProducts'));
    }

    public function categories()
    {
        $categories = Category::with('products')->where('is_active', true)->get();
        
        return view('frontend.categories', compact('categories'));
    }

    public function categoryProducts($id)
    {
        $category = Category::with('products')->findOrFail($id);
        $products = $category->products()->where('stock', '>', 0)->paginate(12);
        
        return view('frontend.category-products', compact('category', 'products'));
    }

    public function contact()
    {
        return view('frontend.contact');
    }

    public function about()
    {
        return view('frontend.about');
    }
}
