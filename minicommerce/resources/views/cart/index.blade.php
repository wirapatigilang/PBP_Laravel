@extends('layouts.app') {{-- ganti kalau layout-mu beda --}}

@section('content')
<div class="max-w-5xl mx-auto p-6">
  <h1 class="text-2xl font-bold mb-4">🛒 Your Cart</h1>

  @if(session('success'))
    <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">
      {{ session('success') }}
    </div>
  @endif

  @if($items->isEmpty())
    <p>Cart is empty.</p>
    <a href="{{ route('products.index') }}" class="text-blue-600 underline">Back to products</a>
  @else
    <div class="overflow-x-auto bg-white rounded shadow">
      <table class="w-full">
        <thead class="bg-gray-50">
          <tr>
            <th class="text-left p-3">Product</th>
            <th class="text-left p-3">Price</th>
            <th class="text-left p-3">Qty</th>
            <th class="text-left p-3">Subtotal</th>
            <th class="p-3"></th>
          </tr>
        </thead>
        <tbody>
          @foreach($items as $item)
            @php $price = $item->price_at_add ?? $item->product->price; @endphp
            <tr class="border-t">
              <td class="p-3">{{ $item->product->name }}</td>
              <td class="p-3">Rp{{ number_format($price,0,',','.') }}</td>
              <td class="p-3">
                <form action="{{ route('cart.update', $item) }}" method="POST" class="inline-flex items-center gap-2">
                  @csrf @method('PATCH')
                  <input type="number" name="quantity" min="1" value="{{ $item->quantity }}"
                         class="w-20 border rounded px-2 py-1">
                  <button class="px-3 py-1 bg-gray-800 text-white rounded">Update</button>
                </form>
              </td>
              <td class="p-3 font-semibold">Rp{{ number_format($item->subtotal,0,',','.') }}</td>
              <td class="p-3 text-right">
                <form action="{{ route('cart.destroy', $item) }}" method="POST"
                      onsubmit="return confirm('Remove item?')">
                  @csrf @method('DELETE')
                  <button class="px-3 py-1 bg-red-600 text-white rounded">Remove</button>
                </form>
              </td>
            </tr>
          @endforeach
        </tbody>
        <tfoot class="border-t">
          <tr>
            <td class="p-3" colspan="3"><strong>Total</strong></td>
            <td class="p-3 font-bold">Rp{{ number_format($total,0,',','.') }}</td>
            <td class="p-3 text-right">
              <form action="{{ route('cart.clear') }}" method="POST" onsubmit="return confirm('Clear cart?')">
                @csrf @method('DELETE')
                <button class="px-3 py-1 bg-gray-200 rounded">Clear</button>
              </form>
            </td>
          </tr>
        </tfoot>
      </table>
    </div>
  @endif
</div>
@endsection
