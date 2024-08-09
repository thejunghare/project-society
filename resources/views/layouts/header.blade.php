<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="//unpkg.com/alpinejs" defer></script>
    {{-- //    <title>{{ config('app.name', 'Laravel') }}</title> --}}
    <title>{{ $title ?? 'Title' }}</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.5/flowbite.min.js"></script>
    

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    
     {{-- <link rel="icon" href=""> --}}
{{--     <link href="lib/noty.css" rel="stylesheet">
    <script src="lib/noty.js" type="text/javascript"></script>
 --}}
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
