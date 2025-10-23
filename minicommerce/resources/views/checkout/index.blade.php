@extends('layouts.app')

@section('content')
@php
  // fallback aman biar view nggak meledak kalau ada variabel yang belum dikirim
  $user          = $user          ?? auth()->user();
  $grouped       = $grouped       ?? collect();
  $itemsSubtotal = $itemsSubtotal ?? 0;
  $shippingTotal = $shippingTotal ?? 0;
  $serviceFee    = $serviceFee    ?? 3000;
  $grandTotal    = $grandTotal    ?? ($itemsSubtotal + $shippingTotal + $serviceFee);
@endphp

<div class="max-w-3xl mx-auto p-6">
  <h2 class="text-2xl font-bold mb-4">Checkout</h2>

  {{-- Barang per "Toko" (satu grup default) --}}
  @forelse($grouped as $store => $list)
    <div class="bg-white rounded shadow mb-4">
      <div class="px-4 py-2 border-b">
        <span class="bg-amber-200 text-amber-900 px-2 py-0.5 rounded text-xs mr-2">Star+</span>
        <span class="font-semibold">{{ $store ?: 'Toko' }}</span>
      </div>

      @foreach($list as $it)
        @php
          $prod  = $it->product ?? null;
          $pname = $prod->name ?? 'Produk';
          $price = $it->price_at_add ?? ($prod->price ?? 0);
          $qty   = (int) ($it->quantity ?? 0);
        @endphp
        <div class="px-4 py-3 flex justify-between border-b">
          <div>
            <div class="font-medium">{{ $pname }}</div>
            <div class="text-sm text-gray-500">x{{ $qty }}</div>
          </div>
          <div class="text-right">
            <div class="font-semibold">Rp{{ number_format($price,0,',','.') }}</div>
          </div>
        </div>
      @endforeach
    </div>
  @empty
    <div class="bg-white rounded shadow p-4 mb-4 text-gray-600">
      Keranjang kosong.
    </div>
  @endforelse

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

  {{-- Pesan error/sukses --}}
  @if(session('error'))
    <div class="mb-4 p-3 rounded bg-red-100 text-red-800">{{ session('error') }}</div>
  @endif

  @if($errors->any())
    <div class="mb-4 p-3 rounded bg-red-100 text-red-800">
      <ul class="list-disc pl-5">
        @foreach($errors->all() as $e)
          <li>{{ $e }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  @if(session('success'))
    <div class="mb-4 p-3 rounded bg-green-100 text-green-800">{{ session('success') }}</div>
  @endif

  {{-- ========= FORM PLACE ORDER ========= --}}
  <form action="{{ route('checkout.place') }}" method="POST" class="space-y-4">
    @csrf

    {{-- WAJIB: opsi pengiriman selalu terkirim --}}
    <input type="hidden" name="shipping_option" value="senja_shipping">

    {{-- Form Informasi Pengiriman --}}
    <div class="bg-white rounded shadow p-4">
      <div class="font-semibold mb-4">Informasi Pengiriman</div>
      
      {{-- Nama Penerima --}}
      <div class="mb-3">
        <label for="recipient_name" class="block text-sm font-medium text-gray-700 mb-1">
          Nama Penerima <span class="text-red-500">*</span>
        </label>
        <input 
          type="text" 
          id="recipient_name"
          name="recipient_name" 
          value="{{ old('recipient_name', $user->name) }}"
          class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
          placeholder="Masukkan nama penerima"
          required
        >
        @error('recipient_name')
          <div class="text-sm text-red-600 mt-1">{{ $message }}</div>
        @enderror
      </div>

      {{-- No. Telepon --}}
      <div class="mb-3">
        <label for="recipient_phone" class="block text-sm font-medium text-gray-700 mb-1">
          No. Telepon <span class="text-red-500">*</span>
        </label>
        <input
          id="recipient_phone"
          name="recipient_phone"
          type="text"
          class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('recipient_phone') is-invalid @enderror"
          placeholder="Contoh: 081234567890"
          inputmode="numeric"
          pattern="(?!0{12})0\d{11}"   {{-- tolak 12 nol di level HTML --}}
          minlength="12" maxlength="12"
          value="{{ old('recipient_phone', $user->phone) }}"
          oninput="
            this.value = this.value.replace(/\D/g,'').slice(0,12);
            if (this.value === '000000000000') {
              this.setCustomValidity('Nomor telepon tidak boleh 000000000000.');
            } else {
              this.setCustomValidity('');
            }
          "
          required
        />
        @error('recipient_phone')
          <div class="text-sm text-red-600 mt-1">{{ $message }}</div>
        @enderror
        <div class="text-xs text-gray-500 mt-1">
          Wajib 12 digit, hanya angka, diawali 0, dan tidak boleh semua nol (misal: 08XXXXXXXXXX).
        </div>
      </div>

      {{-- Alamat Lengkap --}}
      <div class="mb-3">
        <label for="address" class="block text-sm font-medium text-gray-700 mb-1">
          Alamat Lengkap <span class="text-red-500">*</span>
        </label>
        <textarea 
          id="address"
          name="address" 
          rows="3"
          class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
          placeholder="Masukkan alamat lengkap (jalan, no. rumah, RT/RW, kelurahan, kecamatan, kota, kode pos)"
          required
        >{{ old('address', $user->address) }}</textarea>
        @error('address')
          <div class="text-sm text-red-600 mt-1">{{ $message }}</div>
        @enderror
        <div class="text-xs text-gray-500 mt-1">
          Pastikan alamat lengkap dan jelas untuk mempermudah pengiriman
        </div>
      </div>
    </div>

    {{-- Metode Pembayaran --}}
    <div class="bg-white rounded shadow p-4">
      <div class="font-semibold mb-2">Metode Pembayaran</div>

      <label class="flex items-center gap-2 mb-2">
        <input type="radio" name="payment_method" value="transfer_bank"
               {{ old('payment_method','transfer_bank')==='transfer_bank' ? 'checked' : '' }}>
        <span>Transfer Bank</span>
      </label>

      <label class="flex items-center gap-2 mb-2">
        <input type="radio" name="payment_method" value="qris"
               {{ old('payment_method')==='qris' ? 'checked' : '' }}>
        <span>QRIS</span>
      </label>

      <label class="flex items-center gap-2">
        <input type="radio" name="payment_method" value="cod"
               {{ old('payment_method')==='cod' ? 'checked' : '' }}>
        <span>COD</span>
      </label>

      @error('payment_method')
        <div class="text-sm text-red-600 mt-2">{{ $message }}</div>
      @enderror
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
      <button type="submit"
              class="px-5 py-2.5 rounded bg-orange-600 hover:bg-orange-700 text-white font-semibold">
        Buat Pesanan
      </button>
    </div>
  </form>
  {{-- ========= END FORM ========= --}}
</div>
@endsection
