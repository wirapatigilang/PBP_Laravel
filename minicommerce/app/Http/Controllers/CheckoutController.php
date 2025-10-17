<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\CartItem;

class CheckoutController extends Controller
{
    private function getItems()
    {
        if (!auth()->check()) {
            return collect([]);
        }
        
        return CartItem::with('product')
            ->where('user_id', auth()->id())
            ->get();
    }

    public function show(Request $request)
    {
        $items         = $this->getItems();
        $itemsSubtotal = $items->sum(fn($i) => $i->subtotal); 

        $shippingTotal = 0;     
        $serviceFee    = 3000; 
        $grandTotal    = $itemsSubtotal + $shippingTotal + $serviceFee;


        $grouped = collect(['Toko' => $items]);

        $user = auth()->user();

        return view('checkout.index', compact(
            'items','grouped','itemsSubtotal','shippingTotal','serviceFee','grandTotal','user'
        ));
    }

    public function place(Request $request)
    {
        $request->validate([
            'payment_method' => 'required|in:transfer_bank,qris,cod',
            'shipping_option'=> 'required|in:senja_shipping',
            'address'        => 'required|string|min:10',
            'recipient_name' => 'required|string|max:255',
            'recipient_phone'=> 'required|string|max:20',
        ]);

        $items = $this->getItems();
        if ($items->isEmpty()) return back()->with('error','Keranjang kosong.');

        // Cek stock availability sebelum proses order
        foreach ($items as $item) {
            if (!$item->product) {
                return back()->with('error', 'Produk tidak ditemukan.');
            }
            
            if ($item->product->stock < $item->quantity) {
                return back()->with('error', 
                    "Stock tidak mencukupi untuk produk {$item->product->name}. Stock tersedia: {$item->product->stock}"
                );
            }
        }

        $itemsSubtotal = $items->sum(fn($i) => $i->subtotal);
        $shippingTotal = 0;
        $serviceFee    = 3000;
        $grandTotal    = $itemsSubtotal + $shippingTotal + $serviceFee;

        $order = DB::transaction(function () use ($items, $shippingTotal, $serviceFee, $grandTotal, $request) {
            $order = Order::create([
                'user_id'        => auth()->id(),
                'total_amount'   => $grandTotal,
                'payment_method' => $request->payment_method, 
                'payment_status' => 'success',                
                'shipping_method'=> 'Senja Shipping',
                'shipping_cost'  => $shippingTotal,
                'service_fee'    => $serviceFee,
                'paid_at'        => Carbon::now(),
            ]);

            foreach ($items as $it) {
                $price = $it->price_at_add ?? ($it->product->price ?? 0);
                
                // Create order item
                OrderItem::create([
                    'order_id'   => $order->id,
                    'product_id' => $it->product_id,
                    'name'       => $it->product->name ?? 'Produk',
                    'price'      => $price,
                    'qty'        => $it->quantity,
                    'subtotal'   => $price * $it->quantity,
                    'store_name' => 'Toko',
                    'status'     => 'pending',
                    'address'    => $request->address,
                ]);

                // Kurangi stock produk
                $it->product->decrement('stock', $it->quantity);
            }

            // Hapus cart items setelah order berhasil
            CartItem::where('user_id', auth()->id())->delete();

            return $order;
        });

        return redirect()->route('orders.success', $order)
            ->with('success','Pesanan berhasil dibuat.');
    }

    public function success(Order $order)
    {
        abort_if($order->user_id !== auth()->id(), 403);
        return view('checkout.success', compact('order'));
    }
}
