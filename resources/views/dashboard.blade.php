<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <x-success-toaster />

    @if (!Auth::user()->member)
        {{-- User ID exists in another_table --}}
        <x-member-register-button />

        {{-- <livewire:societies.society-form-option /> --}}
        @livewire('societies.society-form-option')
    @endif
</x-app-layout>
