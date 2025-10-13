<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

use App\Models\Order;
use App\Models\Order_item; // sesuai penamaan modelmu
use App\Models\CartItem;
use App\Models\Product;

class CheckoutController extends Controller
{
    /**
<<<<<<< HEAD
     * GET /checkout — tampilkan halaman checkout
=======
     * GET /checkout — tampilkan halaman checkout (sinkron dengan index.blade.php kamu)
>>>>>>> 02edfab (WIP: local changes before syncing with upstream)
     */
    public function show()
    {
        $items = $this->getItems();
        if ($items->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Keranjang kosong.');
        }

        $itemsSubtotal = $items->sum(fn ($i) => $i->subtotal);
        $shippingTotal = 0;
        $serviceFee    = 3000;
        $grandTotal    = $itemsSubtotal + $shippingTotal + $serviceFee;

<<<<<<< HEAD
        // Group per toko agar cocok dengan Blade ($grouped)
=======
        // Tambahan: group per toko agar cocok dengan Blade ($grouped)
>>>>>>> 02edfab (WIP: local changes before syncing with upstream)
        $grouped = $items->groupBy(fn ($i) => $i->store_name ?? 'Toko');

        return view('checkout.index', [
            'user'          => auth()->user(),
            'grouped'       => $grouped,        // dipakai di Blade
            'items'         => $items,
            'itemsSubtotal' => $itemsSubtotal,
            'shippingTotal' => $shippingTotal,
            'serviceFee'    => $serviceFee,
            'grandTotal'    => $grandTotal,
        ]);
    }

    /**
     * POST /checkout/place — proses pembuatan order
     */
    public function place(Request $request)
    {
        // Pastikan ada nilai default (sesuai hidden input di Blade)
        $request->merge([
            'payment_method'  => $request->input('payment_method', 'transfer_bank'),
            'shipping_option' => $request->input('shipping_option', 'senja_shipping'),
        ]);

        // Validasi input
        $request->validate([
            'payment_method'  => 'required|in:transfer_bank,qris,cod',
            'shipping_option' => 'required|in:senja_shipping',
        ]);

        // Ambil item keranjang
        $items = $this->getItems();
        if ($items->isEmpty()) {
            return back()->with('error', 'Keranjang kosong.');
        }

        // Hitung biaya
        $itemsSubtotal = $items->sum(fn ($i) => $i->subtotal);
        $shippingTotal = 0;
        $serviceFee    = 3000;
        $grandTotal    = $itemsSubtotal + $shippingTotal + $serviceFee;

        try {
            $order = DB::transaction(function () use ($items, $shippingTotal, $serviceFee, $grandTotal, $request) {
<<<<<<< HEAD
=======

>>>>>>> 02edfab (WIP: local changes before syncing with upstream)
                // Lock produk agar aman
                $productIds = $items->pluck('product_id')->all();
                $products = Product::whereIn('id', $productIds)
                    ->lockForUpdate()
                    ->get()
                    ->keyBy('id');

                // Cek stok
                foreach ($items as $it) {
                    $p = $products->get($it->product_id);
                    if (!$p || $p->stock < (int) $it->quantity) {
                        throw new \RuntimeException("Stok untuk {$p?->name} tidak mencukupi.");
                    }
                }

                // 1) Buat order
                $order = Order::create([
                    'user_id'         => auth()->id(),
                    'total_amount'    => $grandTotal,
                    'payment_method'  => $request->payment_method,
                    'payment_status'  => 'success',      // sementara auto-sukses
                    'shipping_method' => 'Senja Shipping',
                    'shipping_cost'   => $shippingTotal,
                    'service_fee'     => $serviceFee,
                    'paid_at'         => Carbon::now(),
                ]);

                // 2) Buat order items + kurangi stok
                foreach ($items as $it) {
                    $p = $products->get($it->product_id);
                    $price = $it->price_at_add ?? ($p->price ?? 0);

<<<<<<< HEAD
                    Order_item::create([
=======
                    OrderItem::create([
>>>>>>> 02edfab (WIP: local changes before syncing with upstream)
                        'order_id'   => $order->id,
                        'product_id' => $p->id,
                        'name'       => $p->name ?? 'Produk',
                        'price'      => $price,
                        'qty'        => (int) $it->quantity,
                        'subtotal'   => $price * (int) $it->quantity,
                        // gunakan store_name dari cart kalau ada, fallback "Toko"
                        'store_name' => $it->store_name ?? 'Toko',
<<<<<<< HEAD
                        // kolom NOT NULL dari migrasi (sesuaikan jika berbeda)
=======
                        // kolom NOT NULL dari migrasi
>>>>>>> 02edfab (WIP: local changes before syncing with upstream)
                        'status'     => 'paid',
                        'address'    => auth()->user()->address ?? '',
                    ]);

                    $p->decrement('stock', (int) $it->quantity);
                }

                // 3) Kosongkan keranjang
                CartItem::where('user_id', auth()->id())->delete();

                return $order;
            });
        } catch (\Throwable $e) {
            return back()->with('error', $e->getMessage())->withInput();
        }

        return redirect()->route('orders.success', $order)
            ->with('success', 'Pesanan berhasil dibuat & stok berkurang.');
    }

    /**
     * GET /orders/{order}/success — halaman sukses order
     */
    public function success(Order $order)
    {
        abort_unless($order->user_id === auth()->id(), 403);
        $order->load('items');
        return view('checkout.success', compact('order'));
    }

    /**
     * Helper: ambil item keranjang + hitung subtotal + set store_name fallback
     */
    private function getItems()
    {
        return CartItem::with('product')
            ->where('user_id', auth()->id())
            ->get()
            ->map(function ($ci) {
                $price = $ci->price_at_add ?? optional($ci->product)->price ?? 0;
                $qty   = (int) $ci->quantity;
                $ci->subtotal   = $price * $qty;
                $ci->product_id = $ci->product_id ?? optional($ci->product)->id;
                $ci->store_name = $ci->store_name ?? 'Toko';  // penting untuk grouping di Blade
                return $ci;
            });
    }
}
