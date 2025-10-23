<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule; // tambahkan
use Carbon\Carbon;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\CartItem;
use App\Models\Product;

class CheckoutController extends Controller
{
    /**
     * GET /checkout — tampilkan halaman checkout
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

        // Group per toko agar cocok dengan Blade ($grouped)
        $grouped = $items->groupBy(fn ($i) => $i->store_name ?? 'Toko');

        return view('checkout.index', [
            'user'          => auth()->user(),
            'grouped'       => $grouped,
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
        //  Validasi input (12 digit, diawali 0, dan TIDAK boleh semua nol)
        $request->validate(
            [
                'payment_method'  => 'required|in:transfer_bank,qris,cod',
                'shipping_option' => 'required|in:senja_shipping',
                'address'         => ['required','string','min:10','max:255'],
                'recipient_name'  => ['required','string','max:255'],
                'recipient_phone' => [
                    'required',
                    'regex:/^(?!0{12}$)0\d{11}$/',  
                    Rule::notIn(['000000000000']),  
                ],
            ],
            [
                'payment_method.required'   => 'Metode pembayaran wajib diisi.',
                'payment_method.in'         => 'Metode pembayaran tidak valid.',
                'shipping_option.required'  => 'Opsi pengiriman wajib diisi.',
                'shipping_option.in'        => 'Opsi pengiriman tidak valid.',
                'address.required'          => 'Alamat wajib diisi.',
                'address.min'               => 'Alamat minimal 10 karakter.',
                'address.max'               => 'Alamat maksimal 255 karakter.',
                'recipient_name.required'   => 'Nama penerima wajib diisi.',
                'recipient_name.max'        => 'Nama penerima terlalu panjang.',
                'recipient_phone.required'  => 'Nomor penerima wajib diisi.',
                'recipient_phone.regex'     => 'Nomor penerima harus 12 digit, hanya angka, diawali 0, dan tidak boleh semua nol.',
                'recipient_phone.not_in'    => 'Nomor penerima tidak boleh 000000000000.',
            ]
        );

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
                // Lock produk agar aman
                $productIds = $items->pluck('product_id')->all();
                $products = Product::whereIn('id', $productIds)
                    ->lockForUpdate()
                    ->get()
                    ->keyBy('id');

                // Cek stok
                foreach ($items as $it) {
                    $p = $products->get($it->product_id);
                    if (!$p) {
                        throw new \RuntimeException("Produk tidak ditemukan.");
                    }
                    if ($p->stock < (int) $it->quantity) {
                        throw new \RuntimeException("Stok untuk {$p->name} tidak mencukupi. Stock tersedia: {$p->stock}");
                    }
                }

                // 1) Buat order
                $order = Order::create([
                    'user_id'         => auth()->id(),
                    'total_amount'    => $grandTotal,
                    'payment_method'  => $request->payment_method,
                    'payment_status'  => 'success',
                    'shipping_method' => 'Senja Shipping',
                    'shipping_cost'   => $shippingTotal,
                    'service_fee'     => $serviceFee,
                    'paid_at'         => Carbon::now(),
                ]);

                // 2) Buat order items + kurangi stok
                foreach ($items as $it) {
                    $p = $products->get($it->product_id);
                    $price = $it->price_at_add ?? ($p->price ?? 0);

                    OrderItem::create([
                        'order_id'   => $order->id,
                        'product_id' => $p->id,
                        'name'       => $p->name ?? 'Produk',
                        'price'      => $price,
                        'qty'        => (int) $it->quantity,
                        'subtotal'   => $price * (int) $it->quantity,
                        'store_name' => $it->store_name ?? 'Toko',
                        'status'     => 'pending',
                        'address'    => $request->address,
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
            ->with('success', 'Pesanan berhasil dibuat.');
    }

    /**
     * GET /orders/{order}/success — halaman sukses order
     */
    public function success(Order $order)
    {
        abort_unless($order->user_id === auth()->id(), 403);
        $order->load('orderItems');
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
                $ci->store_name = $ci->store_name ?? 'Toko';
                return $ci;
            });
    }
}
