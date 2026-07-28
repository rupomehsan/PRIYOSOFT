<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="app-name" content="{{ config('app.name') }}">

    {{-- SEO: title/description/keywords are pulled from Settings > SEO in the admin panel --}}
    <title inertia>{{ $seo['title'] }}</title>
    <meta head-key="description" name="description" content="{{ $seo['description'] }}">
    @if($seo['keywords'])
        <meta head-key="keywords" name="keywords" content="{{ $seo['keywords'] }}">
    @endif
    <meta name="robots" content="index, follow">
    <meta name="author" content="{{ $seo['site_name'] }}">
    <link head-key="canonical" rel="canonical" href="{{ $seo['canonical'] }}">

    {{-- Open Graph --}}
    <meta head-key="og:type" property="og:type" content="website">
    <meta head-key="og:site_name" property="og:site_name" content="{{ $seo['site_name'] }}">
    <meta head-key="og:title" property="og:title" content="{{ $seo['title'] }}">
    <meta head-key="og:description" property="og:description" content="{{ $seo['description'] }}">
    <meta head-key="og:url" property="og:url" content="{{ $seo['url'] }}">
    @if($seo['image'])
        <meta head-key="og:image" property="og:image" content="{{ $seo['image'] }}">
    @endif

    {{-- Twitter Card --}}
    <meta head-key="twitter:card" name="twitter:card" content="summary_large_image">
    <meta head-key="twitter:title" name="twitter:title" content="{{ $seo['title'] }}">
    <meta head-key="twitter:description" name="twitter:description" content="{{ $seo['description'] }}">
    @if($seo['image'])
        <meta head-key="twitter:image" name="twitter:image" content="{{ $seo['image'] }}">
    @endif

    @if($seo['favicon'])
        <link rel="icon" href="{{ $seo['favicon'] }}">
    @endif

    {{-- Structured data --}}
    @if($seo['schema_tag'])
        <script type="application/ld+json">{!! $seo['schema_tag'] !!}</script>
    @else
        <script type="application/ld+json">{!! json_encode(array_filter([
            '@context' => 'https://schema.org',
            '@type' => 'Organization',
            'name' => $seo['site_name'],
            'url' => url('/'),
            'logo' => $seo['image'] ?: null,
        ]), JSON_UNESCAPED_SLASHES) !!}</script>
    @endif

    {{-- Custom meta tags configured in Settings > SEO --}}
    {!! $seo['meta_tag'] !!}

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
