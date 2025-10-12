@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto p-6">
  <div class="bg-green-50 text-green-800 border border-green-200 p-4 rounded mb-4">
    Pesanan berhasil dibuat & pembayaran sukses.
  </div>
  <div class="bg-white rounded shadow p-4">
    <div class="mb-1">Order #{{ $order->id }}</div>
    <div>Status: <b>{{ strtoupper($order->payment_status) }}</b></div>
    <div>Metode: <b>{{ strtoupper($order->payment_method) }}</b></div>
    <div>Pengiriman: <b>{{ $order->shipping_method }}</b> (Rp{{ number_format($order->shipping_cost,0,',','.') }})</div>
    <div>Biaya Layanan: Rp{{ number_format($order->service_fee,0,',','.') }}</div>
    <div class="mt-2 text-lg font-bold">Total: Rp{{ number_format($order->total_amount,0,',','.') }}</div>
  </div>
  <a href="{{ url('/') }}" class="inline-block mt-4 px-4 py-2 rounded border">Kembali ke Beranda</a>
</div>
@endsection
