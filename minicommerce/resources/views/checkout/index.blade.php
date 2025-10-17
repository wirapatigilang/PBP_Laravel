@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto p-6">
  <h2 class="text-2xl font-bold mb-4">Checkout</h2>

  {{-- Form Place Order --}}
  <form action="{{ route('checkout.place') }}" method="POST" class="space-y-4">
    @csrf
    <input type="hidden" name="shipping_option" value="senja_shipping">

    {{-- Alamat Pembeli --}}
    <div class="bg-white rounded shadow p-4">
      <div class="font-semibold mb-3">📍 Informasi Pengiriman</div>
      
      <div class="mb-3">
        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Penerima</label>
        <input 
          type="text" 
          name="recipient_name" 
          value="{{ $user->name }}" 
          required
          class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
          placeholder="Masukkan nama penerima"
        >
      </div>

      <div class="mb-3">
        <label class="block text-sm font-medium text-gray-700 mb-1">No. Telepon</label>
        <input 
          type="text" 
          name="recipient_phone" 
          value="{{ $user->phone ?? '' }}" 
          required
          class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
          placeholder="Contoh: 08123456789"
        >
      </div>

      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Alamat Lengkap</label>
        <textarea 
          name="address" 
          rows="3" 
          required
          class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
          placeholder="Masukkan alamat lengkap (Jalan, RT/RW, Kelurahan, Kecamatan, Kota, Provinsi, Kode Pos)"
        >{{ $user->address ?? '' }}</textarea>
        @error('address')
          <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
      </div>
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
  <div class="bg-white rounded shadow p-4 flex justify-between">
    <div>
      <div class="font-semibold">Opsi Pengiriman</div>
      <div class="text-sm text-gray-500">Reguler — Senja Shipping</div>
    </div>
    <div class="text-right">
      <div class="line-through text-gray-400 text-sm">Rp8.000</div>
      <div class="font-semibold">Rp0</div>
    </div>
  </div>

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
      <button type="submit" class="px-5 py-2.5 rounded bg-orange-600 hover:bg-orange-700 text-white font-semibold">
        Buat Pesanan
      </button>
    </div>
  </form>
</div>
@endsection
