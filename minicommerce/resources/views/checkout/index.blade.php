@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto p-6">
  <h2 class="text-2xl font-bold mb-4">Checkout</h2>

  {{-- Alamat Pembeli --}}
  <div class="bg-white rounded shadow p-4 mb-4">
    <div class="font-semibold">📍 {{ $user->name }} @if($user->phone) ({{ $user->phone }}) @endif</div>
    <div class="text-gray-600 text-sm">{{ $user->address ?? 'Alamat belum diisi' }}</div>
  </div>

  {{-- Barang per "Toko" (satu grup default) --}}
  @foreach($grouped as $store => $list)
    <div class="bg-white rounded shadow mb-4">
      <div class="px-4 py-2 border-b">
        <span class="bg-amber-200 text-amber-900 px-2 py-0.5 rounded text-xs mr-2">Star+</span>
        <span class="font-semibold">{{ $store }}</span>
      </div>
      @foreach($list as $it)
        @php
          $price = $it->price_at_add ?? ($it->product->price ?? 0);
        @endphp
        <div class="px-4 py-3 flex justify-between border-b">
          <div>
            <div class="font-medium">{{ $it->product->name ?? 'Produk' }}</div>
            <div class="text-sm text-gray-500">x{{ $it->quantity }}</div>
          </div>
          <div class="text-right">
            <div class="font-semibold">Rp{{ number_format($price,0,',','.') }}</div>
          </div>
        </div>
      @endforeach
    </div>
  @endforeach

  {{-- Opsi Pengiriman (Senja Shipping Rp0) --}}
  <div class="bg-white rounded shadow p-4 mb-4 flex justify-between">
    <div>
      <div class="font-semibold">Opsi Pengiriman</div>
      <div class="text-sm text-gray-500">Reguler — Senja Shipping</div>
    </div>
    <div class="text-right">
      <div class="line-through text-gray-400 text-sm">Rp8.000</div>
      <div class="font-semibold">Rp0</div>
    </div>
  </div>

  {{-- Form Place Order --}}
  <form action="{{ route('checkout.place') }}" method="POST" class="space-y-4">
    @csrf
    <input type="hidden" name="shipping_option" value="senja_shipping">

    {{-- Metode Pembayaran (formalitas) --}}
    <div class="bg-white rounded shadow p-4">
      <div class="font-semibold mb-2">Metode Pembayaran</div>
      <label class="flex items-center gap-2 mb-2">
        <input type="radio" name="payment_method" value="transfer_bank" required>
        <span>Transfer Bank</span>
      </label>
      <label class="flex items-center gap-2 mb-2">
        <input type="radio" name="payment_method" value="qris">
        <span>QRIS</span>
      </label>
      <label class="flex items-center gap-2">
        <input type="radio" name="payment_method" value="cod">
        <span>COD</span>
      </label>
    </div>

    {{-- Rincian Pembayaran --}}
    <div class="bg-white rounded shadow p-4">
      <div class="font-semibold mb-2">Rincian Pembayaran</div>
      <div class="flex justify-between mb-1">
        <span>Subtotal Pesanan</span>
        <span>Rp{{ number_format($itemsSubtotal,0,',','.') }}</span>
      </div>
      <div class="flex justify-between mb-1">
        <span>Total Pengiriman</span>
        <span>Rp{{ number_format($shippingTotal,0,',','.') }}</span>
      </div>
      <div class="flex justify-between mb-1">
        <span>Biaya Layanan</span>
        <span>Rp{{ number_format($serviceFee,0,',','.') }}</span>
      </div>
      <hr class="my-2">
      <div class="flex justify-between font-bold text-lg">
        <span>Total</span>
        <span>Rp{{ number_format($grandTotal,0,',','.') }}</span>
      </div>
    </div>

    <div class="flex justify-end">
      <button class="px-5 py-2.5 rounded bg-orange-600 hover:bg-orange-700 text-white font-semibold">
        Buat Pesanan
      </button>
    </div>
  </form>
</div>
@endsection
