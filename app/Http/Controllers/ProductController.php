<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $categorySlug = $request->query('category', '');
        $search = trim((string) $request->query('q', ''));

        $categories = Category::active()->withCount('products')->orderBy('name')->get();

        $query = Product::active()->with(['images', 'category']);

        if ($categorySlug !== '') {
            $query->whereHas('category', fn ($c) => $c->where('slug', $categorySlug));
        }
        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $products = $query->latest()->get();
        $showCategoryCards = $categorySlug === '' && $search === '';

        return view('products.index', compact('categories', 'products', 'categorySlug', 'search', 'showCategoryCards'));
    }

    public function show(string $slug)
    {
        $product = Product::active()->with(['images', 'category'])->where('slug', $slug)->firstOrFail();

        $related = Product::active()
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->with('images')
            ->take(4)
            ->get();

        return view('products.show', compact('product', 'related'));
    }
}
