<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{

    public function index(Request $request)
    {
        $items = CartItem::with('product')
            ->where('user_id', $request->user()->id)
            ->get();

        // total = (price_at_add atau harga produk) x qty
        $total = $items->sum(function ($i) {
            $price = $i->price_at_add ?? ($i->product->price ?? 0);
            return $price * $i->quantity;
        });

        return view('cart.index', compact('items', 'total'));
    }


    public function add(Request $request, Product $product)
    {
        $data = $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        // Ambil baris jika sudah ada, kalau tidak buat instance baru
        $row = CartItem::firstOrNew([
            'user_id'    => $request->user()->id,
            'product_id' => $product->id,
        ]);

        // Tambah jumlah
        $row->quantity = (int) $row->quantity + (int) $data['quantity'];


        if (is_null($row->price_at_add)) {
            $row->price_at_add = $product->price;
        }

        $row->save();

        return back()->with('success', 'Added to cart.');
    }

    public function update(Request $request, CartItem $item)
    {
        abort_unless($item->user_id === $request->user()->id, 403);

        $validated = $request->validate([
            'quantity' => 'required|integer|min:1|max:999',
        ]);

        $item->update([
            'quantity' => (int) $validated['quantity'],
        ]);

        return back()->with('success', 'Quantity updated.');
    }


    public function destroy(Request $request, CartItem $item)
    {
        abort_unless($item->user_id === $request->user()->id, 403);

        $item->delete();

        return back()->with('success', 'Item removed.');
    }


    public function clear(Request $request)
    {
        CartItem::where('user_id', $request->user()->id)->delete();

        return back()->with('success', 'Cart cleared.');
    }
}
