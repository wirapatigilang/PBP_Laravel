<x-guest-layout>
    <!-- Header -->
    <div class="mb-6 text-center">
        <h2 class="text-2xl font-bold text-gray-900 mb-2">Welcome Back!</h2>
        <p class="text-gray-600 text-sm">Sign in to your account to continue</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" class="text-gray-700 font-medium" />
            <x-text-input 
                id="email" 
                class="block mt-2 w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500" 
                type="email" 
                name="email" 
                :value="old('email')" 
                required 
                autofocus 
                autocomplete="username" 
                placeholder="your@email.com"
            />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <x-input-label for="password" :value="__('Password')" class="text-gray-700 font-medium" />
            <x-text-input 
                id="password" 
                class="block mt-2 w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                type="password"
                name="password"
                required 
                autocomplete="current-password"
                placeholder="••••••••"
            />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center justify-between">
            <label for="remember_me" class="inline-flex items-center">
                <input 
                    id="remember_me" 
                    type="checkbox" 
                    class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500" 
                    name="remember"
                >
                <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
            </label>

            @if (Route::has('password.request'))
                <a class="text-sm text-blue-600 hover:text-blue-700 font-medium transition-colors" href="{{ route('password.request') }}">
                    {{ __('Forgot password?') }}
                </a>
            @endif
        </div>

        <div class="space-y-4">
            <button type="submit" class="w-full bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white font-semibold py-3 px-4 rounded-lg transition-all duration-200 shadow-md hover:shadow-lg">
                {{ __('Log in') }}
            </button>

            <div class="text-center text-sm text-gray-600">
                Don't have an account? 
                <a href="{{ route('register') }}" class="text-blue-600 hover:text-blue-700 font-medium transition-colors">
                    Sign up
                </a>
            </div>
        </div>
    </form>
</x-guest-layout>
