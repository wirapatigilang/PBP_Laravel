<x-guest-layout>
    <!-- Header -->
    <div class="mb-6 text-center">
        <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-br from-blue-100 to-purple-100 rounded-full mb-4">
            <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path>
            </svg>
        </div>
        <h2 class="text-2xl font-bold text-gray-900 mb-2">Forgot Password?</h2>
        <p class="text-gray-600 text-sm">
            {{ __('No problem! Just enter your email and we\'ll send you a password reset link.') }}
        </p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
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
                placeholder="your@email.com"
            />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="space-y-4">
            <button type="submit" class="w-full bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white font-semibold py-3 px-4 rounded-lg transition-all duration-200 shadow-md hover:shadow-lg">
                {{ __('Email Password Reset Link') }}
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
