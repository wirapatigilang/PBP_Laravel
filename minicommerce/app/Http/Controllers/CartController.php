<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index(Request $r){
        $items = CartItem::with('product')->where('user_id',$r->user()->id)->get();
        $total = $items->sum(fn($i)=>($i->price_at_add ?? $i->product->price) * $i->quantity);
        return view('cart.index', compact('items','total'));
    }

    public function add(Request $r, Product $product){
        $qty = (int) $r->input('quantity', 1);
        $item = CartItem::firstOrNew(['user_id'=>$r->user()->id,'product_id'=>$product->id]);
        $item->quantity = ($item->exists ? $item->quantity : 0) + max(1,$qty);
        if(!$item->exists) $item->price_at_add = $product->price;
        $item->save();
        return back()->with('success','Product added to cart.');
    }

    public function update(Request $r, CartItem $item){
        abort_unless($item->user_id === $r->user()->id, 403);
        $item->update($r->validate(['quantity'=>'required|integer|min:1|max:999']));
        return back()->with('success','Quantity updated.');
    }

    public function destroy(Request $r, CartItem $item){
        abort_unless($item->user_id === $r->user()->id, 403);
        $item->delete();
        return back()->with('success','Item removed.');
    }

    public function clear(Request $r){
        CartItem::where('user_id',$r->user()->id)->delete();
        return back()->with('success','Cart cleared.');
    }
}
