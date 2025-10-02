<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- DEVELOP title condition -->
    @if (app()->environment('production'))
        <title>App Motos - @yield('title')</title>
    @else
        <title>DEVELOP</title>
    @endif

    <!-- PWA Manifest -->
    <link rel="manifest" href="{{ asset('manifest.json') }}">

    <!-- Theme & Background Colors -->
    <meta name="theme-color" content="#007aff">
    <meta name="background-color" content="#ffffff">

    <!-- Apple PWA Meta Tags -->
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-title" content="App Motos">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <!-- Updated icon path to match public/icons directory -->
    <link rel="apple-touch-icon" sizes="192x192" href="{{ asset('icons/icon-192x192.png') }}">

    <!-- Additional page styles -->
    @stack('styles')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body>
    <div class="container bg-gray-100">
        @yield('content')
    </div>

    {{-- Footer with navigation, hidden on login --}}
    @unless (Route::is('login'))
        @include('footer')
    @endunless


    <!-- Service Worker Registration -->
    @if (app()->environment('production'))
        <script>
            if ('serviceWorker' in navigator) {
                window.addEventListener('load', function() {
                    navigator.serviceWorker.register('{{ asset('sw.js') }}')
                        .then(reg => console.log('SW registered:', reg))
                        .catch(err => console.error('SW error:', err));
                });
            }
        </script>
    @endif

    <!-- Additional page scripts -->
    @stack('scripts')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
