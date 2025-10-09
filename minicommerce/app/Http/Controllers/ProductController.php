<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /** Display a paginated list of active products for visitors. */
    public function index(Request $request)
    {
        $query = Product::with('category')->where('is_active', true);

        if ($q = $request->query('q')) {
            $query->where('name', 'like', '%'.$q.'%');
        }

        if ($category = $request->query('category')) {
            $query->where('category_id', $category);
        }

        $products = $query->latest()->paginate(12)->withQueryString();

        // pass categories for filter dropdown
        $categories = \App\Models\Category::orderBy('name')->get();

        return view('products.index', compact('products', 'categories'));
    }

    /** Display a single product detail for visitors. */
    public function show(Product $product)
    {
        if (! $product->is_active) {
            abort(404);
        }
        return view('products.show', compact('product'));
    }
}
