<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight">
            Dashboard
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white text-gray-900 border border-gray-200 shadow-sm sm:rounded-lg p-6">
                Selamat datang, {{ auth()->user()->name }} 👋
            </div>
        </div>
    </div>
</x-app-layout>
