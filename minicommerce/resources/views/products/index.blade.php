@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-8 px-4">
    <h1 class="text-3xl font-bold mb-6">Products</h1>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
        @foreach($products as $product)
            <div class="bg-white rounded shadow p-4">
                @if($product->image)
                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-48 object-cover mb-3">
                @endif
                <h2 class="font-semibold text-lg">{{ $product->name }}</h2>
                <p class="text-sm text-gray-600">{{ optional($product->category)->name }}</p>
                <p class="mt-2 font-bold">${{ number_format($product->price, 2) }}</p>
                <div class="mt-3">
                    <a href="{{ route('products.show', $product) }}" class="text-blue-600">View details</a>
                </div>
            </div>
        @endforeach
    </div>

    <div class="mt-6">{{ $products->links() }}</div>
</div>
@endsection
