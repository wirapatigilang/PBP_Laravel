<x-guest-layout>
    <!-- Header -->
    <div class="mb-6 text-center">
        <h2 class="text-2xl font-bold text-gray-900 mb-2">Create Account</h2>
        <p class="text-gray-600 text-sm">Join us and start shopping today!</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-5">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" class="text-gray-700 font-medium" />
            <x-text-input 
                id="name" 
                class="block mt-2 w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500" 
                type="text" 
                name="name" 
                :value="old('name')" 
                required 
                autofocus 
                autocomplete="name" 
                placeholder="John Doe"
            />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

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
                autocomplete="new-password" 
                placeholder="••••••••"
            />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div>
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="text-gray-700 font-medium" />
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
                {{ __('Create Account') }}
            </button>

            <div class="text-center text-sm text-gray-600">
                Already have an account? 
                <a href="{{ route('login') }}" class="text-blue-600 hover:text-blue-700 font-medium transition-colors">
                    Sign in
                </a>
            </div>
        </div>
    </form>
</x-guest-layout>
