<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="app-name" content="{{ config('app.name') }}">
    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">


    {{-- Theme CSS --}}
    @if(file_exists(public_path('css/theme.css')))
        <link rel="stylesheet" href="{{ asset('css/theme.css') }}">
    @endif

    
    {{-- Inertia Head --}}
    @inertiaHead
</head>

<body>

    @inertia

    {{-- jQuery (required by axios interceptor loader) --}}
    <script src="{{ asset('plugins/js/jquery.min.js') }}"></script>

    {{-- Vite: Bootstrap CSS + FA6 + Vue app bundled together --}}
    @vite(['resources/js/frontend/app.js'])
</body>

</html>
