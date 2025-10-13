@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto p-6">
  {{-- Banner sukses --}}
  <div class="bg-green-50 text-green-800 border border-green-200 p-4 rounded mb-4">
    Pesanan berhasil dibuat & stok telah diperbarui.
  </div>

  {{-- Ringkasan Order --}}
  <div class="bg-white rounded shadow p-4 mb-4">
    <div class="flex items-center justify-between mb-2">
      <div class="text-sm text-gray-600">Order</div>
      <div class="text-sm font-semibold">#{{ $order->id }}</div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 text-sm">
      <div>Status: <b class="capitalize">{{ $order->payment_status }}</b></div>
      <div>Metode: <b class="uppercase">{{ str_replace('_',' ',$order->payment_method) }}</b></div>
      <div>Pengiriman: <b>{{ $order->shipping_method }}</b></div>
      <div>Ongkir: Rp{{ number_format($order->shipping_cost,0,',','.') }}</div>
      <div>Biaya Layanan: Rp{{ number_format($order->service_fee,0,',','.') }}</div>
      <div>Dibayar: {{ optional($order->paid_at)->format('d M Y H:i') ?? '-' }}</div>
    </div>

    <hr class="my-3">

    <div class="flex items-center justify-between">
      <span class="font-semibold">Total</span>
      <span class="text-lg font-bold">Rp{{ number_format($order->total_amount,0,',','.') }}</span>
    </div>
  </div>

  {{-- Rincian Item --}}
  @if($order->relationLoaded('items') && $order->items->count())
    <div class="bg-white rounded shadow p-4 mb-6">
      <div class="font-semibold mb-3">Rincian Item</div>
      <div class="divide-y">
        @foreach($order->items as $it)
          <div class="py-2 flex justify-between">
            <div>
              <div class="font-medium">{{ $it->name }}</div>
              <div class="text-xs text-gray-500">x{{ $it->qty }} • {{ $it->store_name ?? 'Toko' }}</div>
            </div>
            <div class="text-right">
              <div>Rp{{ number_format($it->price,0,',','.') }}</div>
              <div class="text-xs text-gray-500">Subtotal: Rp{{ number_format($it->subtotal,0,',','.') }}</div>
            </div>
          </div>
        @endforeach
      </div>
    </div>
  @endif

  {{-- Tombol OK kembali ke dashboard --}}
  <div class="flex gap-3">
    <a href="{{ url('/') }}"
       class="inline-flex items-center justify-center px-5 py-2.5 rounded border border-gray-300 hover:bg-gray-50">
      Oke
    </a>
    <a href="{{ route('checkout.show') }}"
       class="inline-flex items-center justify-center px-5 py-2.5 rounded bg-blue-600 text-white font-semibold hover:bg-blue-700">
      Belanja Lagi
    </a>
  </div>
</div>
@endsection
