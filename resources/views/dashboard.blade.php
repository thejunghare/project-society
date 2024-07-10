<x-app-layout>
    {{-- <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('pay') }}
        </h2>

    </x-slot> --}}
    {{-- @section('title', 'User Dashboard') --}}

    <x-success-toaster />

    @if (!Auth::user()->member)
        {{-- User ID exists in another_table --}}
        <x-member-register-button />

        {{-- <livewire:societies.society-form-option /> --}}
        @livewire('societies.society-form-option')
    @else
        {{-- User is a member of a society --}}
        @livewire('societies.display-member-info')
    @endif
</x-app-layout>
