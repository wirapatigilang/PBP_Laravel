<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /** Display a paginated list of active products for visitors. */
    public function index()
    {
        $products = Product::with('category')->where('is_active', true)->latest()->paginate(12);
        return view('products.index', compact('products'));
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
