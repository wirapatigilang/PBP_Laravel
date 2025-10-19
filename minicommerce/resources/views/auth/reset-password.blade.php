<x-guest-layout>
    <!-- Header -->
    <div class="mb-6 text-center">
        <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-br from-blue-100 to-purple-100 rounded-full mb-4">
            <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
            </svg>
        </div>
        <h2 class="text-2xl font-bold text-gray-900 mb-2">Reset Password</h2>
        <p class="text-gray-600 text-sm">Enter your new password below</p>
    </div>

    <form method="POST" action="{{ route('password.store') }}" class="space-y-5">
        @csrf

        <!-- Password Reset Token -->
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" class="text-gray-700 font-medium" />
            <x-text-input 
                id="email" 
                class="block mt-2 w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 bg-gray-50" 
                type="email" 
                name="email" 
                :value="old('email', $request->email)" 
                required 
                autofocus 
                autocomplete="username" 
                readonly
            />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <x-input-label for="password" :value="__('New Password')" class="text-gray-700 font-medium" />
            <x-text-input 
                id="password" 
                class="block mt-2 w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500" 
                type="password" 
                name="password" 
                required 
                autocomplete="new-password" 
                placeholder="••••••••"
            />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div>
            <x-input-label for="password_confirmation" :value="__('Confirm New Password')" class="text-gray-700 font-medium" />
            <x-text-input 
                id="password_confirmation" 
                class="block mt-2 w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                type="password"
                name="password_confirmation" 
                required 
                autocomplete="new-password" 
                placeholder="••••••••"
            />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="space-y-4">
            <button type="submit" class="w-full bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white font-semibold py-3 px-4 rounded-lg transition-all duration-200 shadow-md hover:shadow-lg">
                {{ __('Reset Password') }}
            </button>

            <div class="text-center text-sm text-gray-600">
                Remember your password? 
                <a href="{{ route('login') }}" class="text-blue-600 hover:text-blue-700 font-medium transition-colors">
                    Back to login
                </a>
            </div>
        </div>
    </form>
</x-guest-layout>
