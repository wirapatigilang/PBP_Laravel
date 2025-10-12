@extends('layouts.app')

@section('content')
<div class="bg-gradient-to-br from-blue-50 via-white to-purple-50 min-h-screen py-12">
  <div class="max-w-6xl mx-auto px-4">

    {{-- Flash message --}}
    @if(session('success'))
      <div class="mb-6 p-3 rounded bg-green-100 text-green-800">
        {{ session('success') }}
      </div>
    @endif

    {{-- Breadcrumb --}}
    <nav class="mb-8">
      <ol class="flex items-center space-x-2 text-sm">
        <li>
          <a href="{{ route('products.index') }}" class="text-gray-600 hover:text-blue-600 transition">
            Products
          </a>
        </li>
        <li class="text-gray-400">/</li>
        <li class="text-gray-900 font-medium">{{ $product->name }}</li>
      </ol>
    </nav>

    {{-- Product Detail Card --}}
    <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
      <div class="grid grid-cols-1 lg:grid-cols-2 gap-0">

        {{-- Product Image --}}
        <div class="relative bg-gray-50">
          @if($product->image)
            <div class="aspect-square lg:aspect-auto lg:h-full">
              <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
            </div>
          @else
            <div class="aspect-square lg:aspect-auto lg:h-full flex items-center justify-center bg-gradient-to-br from-gray-200 to-gray-300">
              <svg class="w-32 h-32 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
              </svg>
            </div>
          @endif

          {{-- Stock badge --}}
          <div class="absolute top-6 right-6">
            @if($product->stock > 10)
              <span class="bg-green-500 text-white px-4 py-2 rounded-full text-sm font-semibold shadow-lg">In Stock</span>
            @elseif($product->stock > 0)
              <span class="bg-orange-500 text-white px-4 py-2 rounded-full text-sm font-semibold shadow-lg">Low Stock</span>
            @else
              <span class="bg-red-500 text-white px-4 py-2 rounded-full text-sm font-semibold shadow-lg">Out of Stock</span>
            @endif
          </div>
        </div>

        {{-- Product Info --}}
        <div class="p-8 lg:p-12 flex flex-col">

          {{-- Category --}}
          @if($product->category)
            <div class="mb-4">
              <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                </svg>
                {{ $product->category->name }}
              </span>
            </div>
          @endif

          {{-- Name --}}
          <h1 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-4">
            {{ $product->name }}
          </h1>

          {{-- Price --}}
          <div class="mb-6">
            <div class="flex items-baseline gap-2">
              <span class="text-4xl font-bold text-gray-900">
                Rp{{ number_format($product->price, 0, ',', '.') }}
              </span>
            </div>
          </div>

          <div class="border-t border-gray-200 my-6"></div>

          {{-- Description --}}
          <div class="mb-6 flex-grow">
            <h2 class="text-lg font-semibold text-gray-900 mb-3">Description</h2>
            <p class="text-gray-600 leading-relaxed">
              {{ $product->description ?: 'No description available for this product.' }}
            </p>
          </div>

          {{-- Stock info --}}
          <div class="bg-gray-50 rounded-xl p-4 mb-6">
            <div class="flex items-center justify-between">
              <div class="flex items-center gap-2">
                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                </svg>
                <span class="text-gray-700 font-medium">Available Stock:</span>
              </div>
              <span class="text-xl font-bold text-gray-900">{{ $product->stock }} units</span>
            </div>
          </div>

          {{-- Actions --}}
          @auth
            @if($product->stock > 0)
              {{-- FORM ADD TO CART (POST) --}}
              <form action="{{ route('cart.add', $product) }}" method="POST" class="flex flex-col sm:flex-row gap-3">
                @csrf

                {{-- Qty picker --}}
                <div class="flex items-center gap-2">
                  <label for="qty" class="text-sm text-gray-600">Qty</label>
                  <input
                    id="qty"
                    type="number"
                    name="quantity"
                    min="1"
                    @if(!empty($product->stock)) max="{{ $product->stock }}" @endif
                    value="1"
                    class="w-24 border border-gray-300 rounded-xl px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                  @if(!empty($product->stock))
                    <span class="text-xs text-gray-500">max {{ $product->stock }}</span>
                  @endif
                </div>

                <button type="submit"
                        class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-4 px-6 rounded-xl transition-colors duration-200 flex items-center justify-center gap-2 shadow-lg shadow-blue-600/30">
                  <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                  </svg>
                  Add to Cart
                </button>
              </form>
            @else
              <button disabled class="w-full bg-gray-300 text-gray-600 font-semibold py-4 px-6 rounded-xl cursor-not-allowed">
                Out of Stock
              </button>
            @endif
          @else
            <a href="{{ route('login') }}"
               class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-4 px-6 rounded-xl inline-flex items-center justify-center gap-2">
              Login to Add to Cart
            </a>
          @endauth

          {{-- Extra info --}}
          <div class="mt-6 pt-6 border-t border-gray-200">
            <div class="grid grid-cols-2 gap-4 text-sm">
              <div class="flex items-center gap-2 text-gray-600">
                <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                Free Shipping
              </div>
              <div class="flex items-center gap-2 text-gray-600">
                <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                Secure Payment
              </div>
            </div>
          </div>

        </div>{{-- /info --}}
      </div>
    </div>

    {{-- Back --}}
    <div class="mt-8">
      <a href="{{ route('products.index') }}" class="inline-flex items-center text-gray-600 hover:text-gray-900 transition">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
        </svg>
        Back to Products
      </a>
    </div>

  </div>
</div>
@endsection
