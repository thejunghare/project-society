<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <title>@yield('title')</title>

@include('layouts.header')

<body class="font-sans antialiased">
    @include('layouts.navigation', ['society' => $society ?? null])
    @include('layouts.sidebar')
    {{-- <div class="min-h-screen bg-gray-100 dark:bg-gray-900">

        <!-- Page Heading -->
        @if (isset($header))
            <header class="bg-white dark:bg-gray-800 shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endif

        <!-- Page Content -->
        <main>
            {{ $slot }}
        </main>
    </div> --}}
    @include('layouts.main')

    @include('layouts.script')
</body>

</html>
