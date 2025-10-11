<nav x-data="{ open: false }" class="bg-white border-b border-gray-200 shadow-sm">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('products.index') }}">
                        <img src="{{ asset('image/logo.png') }}" alt="Logo" class="h-20">
                    </a>
                </div>

                <!-- Navigation Links -->
                @auth
                    @if(Auth::user()->role === 'admin')
                        <x-responsive-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                            {{ __('Dashboard') }}
                        </x-responsive-nav-link>
                    @endif
                @endauth
            </div>

            <!-- Search (desktop) -->
            <div class="hidden lg:flex items-center flex-1 max-w-2xl mx-8">
                <form method="GET" action="{{ route('products.index') }}" class="flex gap-2 w-full">
                    <input
                        type="text"
                        name="q"
                        value="{{ request('q') }}"
                        placeholder="Search by name..."
                        class="flex-1 border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    >
                    <select
                        name="category"
                        class="border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    >
                        <option value="">All categories</option>
                        @isset($categories)
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->name }}
                                </option>
                            @endforeach
                        @endisset
                    </select>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg text-sm font-medium transition">
                        Search
                    </button>
                    @if(request()->hasAny(['q','category']) && (request('q') || request('category')))
                        <a href="{{ route('products.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg text-sm text-gray-700 hover:bg-gray-50 transition">
                            Clear
                        </a>
                    @endif
                </form>
            </div>

            <!-- Right side: Cart + User -->
            <div class="hidden sm:flex items-center gap-3">
                <!-- Cart button (desktop) -->
                @auth
                    @php
                        $cartCount = \App\Models\CartItem::where('user_id', auth()->id())->sum('quantity');
                    @endphp
                    <a href="{{ route('cart.index') }}"
                       class="relative inline-flex items-center justify-center h-10 w-10 rounded-lg border border-gray-300 bg-white hover:bg-gray-50 transition"
                       title="Cart">
                        <svg class="h-5 w-5 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                        @if($cartCount > 0)
                            <span class="absolute -top-1 -right-1 min-w-[18px] h-[18px] px-1 rounded-full text-[11px] font-semibold
                                         bg-blue-600 text-white flex items-center justify-center">
                                {{ $cartCount }}
                            </span>
                        @endif
                    </a>
                @endauth>

                <!-- Settings Dropdown -->
                @auth
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                                <div>{{ Auth::user()->name }}</div>
                                <div class="ms-2">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link :href="route('profile.edit')">
                                {{ __('Profile') }}
                            </x-dropdown-link>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')"
                                                 onclick="event.preventDefault(); this.closest('form').submit();">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                @else
                    <a href="{{ route('login') }}" class="px-4 py-2 text-sm border rounded-lg hover:bg-gray-50">Login</a>
                @endauth
            </div>

            <!-- Hamburger (mobile) -->
            <div class="flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-lg text-gray-600 hover:text-gray-700 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden border-t border-gray-200">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
        </div>

        <!-- Mobile Search -->
        <div class="px-4 py-3 border-t border-gray-200">
            <form method="GET" action="{{ route('products.index') }}" class="space-y-2">
                <input
                    type="text"
                    name="q"
                    value="{{ request('q') }}"
                    placeholder="Search by name..."
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
                <select
                    name="category"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
                    <option value="">All categories</option>
                    @isset($categories)
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    @endisset
                </select>
                <div class="flex gap-2">
                    <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium">
                        Search
                    </button>
                    @if(request()->hasAny(['q','category']) && (request('q') || request('category')))
                        <a href="{{ route('products.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg text-sm text-gray-700">
                            Clear
                        </a>
                    @endif
                </div>
            </form>
        </div>

        <!-- Responsive Settings -->
        @auth
            <div class="pt-4 pb-1 border-t border-gray-200">
                <div class="px-4">
                    <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                </div>

                <div class="mt-3 space-y-1">
                    <x-responsive-nav-link :href="route('profile.edit')">
                        {{ __('Profile') }}
                    </x-responsive-nav-link>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-responsive-nav-link :href="route('logout')"
                                               onclick="event.preventDefault(); this.closest('form').submit();">
                            {{ __('Log Out') }}
                        </x-responsive-nav-link>
                    </form>
                </div>
            </div>
        @endauth
    </div>
</nav>
