@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto py-8 px-4">
    <div class="bg-white rounded shadow p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                @if($product->image)
                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                @endif
            </div>
            <div>
                <h1 class="text-2xl font-bold">{{ $product->name }}</h1>
                <p class="text-gray-600">{{ optional($product->category)->name }}</p>
                <p class="mt-4">{{ $product->description }}</p>
                <p class="mt-4 text-xl font-semibold">${{ number_format($product->price, 2) }}</p>
                <p class="mt-2">Stock: {{ $product->stock }}</p>
            </div>
        </div>
    </div>
</div>
@endsection
