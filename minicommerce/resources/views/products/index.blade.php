@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-8 px-4">
    <h1 class="text-3xl font-bold mb-6">Products</h1>

    <form method="GET" action="{{ route('products.index') }}" class="mb-6 flex gap-3">
        <input type="text" name="q" value="{{ request('q') }}" placeholder="Search by name..." class="border rounded px-3 py-2 w-1/2">
        <select name="category" class="border rounded px-3 py-2">
            <option value="">All categories</option>
            @foreach($categories as $cat)
                <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
            @endforeach
        </select>
        <button class="bg-blue-600 text-white px-4 py-2 rounded">Search</button>
        @if(request()->hasAny(['q','category']) && (request('q') || request('category')))
            <a href="{{ route('products.index') }}" class="ml-2 px-3 py-2 border rounded">Clear</a>
        @endif
    </form>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
        @forelse($products as $product)
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
        @empty
            <div class="col-span-full text-center py-12 text-gray-600">
                No products found matching your search.
            </div>
        @endforelse
    </div>

    <div class="mt-6">{{ $products->links() }}</div>
</div>
@endsection
