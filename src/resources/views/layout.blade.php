<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @if (app()->environment('production'))
        <title>MotoRent · @yield('title')</title>
    @else
        <title>DEVELOP</title>
    @endif

    <link rel="manifest" href="{{ asset('manifest.json') }}">
    <meta name="theme-color" content="#111111">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-title" content="MotoRent">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <link rel="apple-touch-icon" sizes="192x192" href="{{ asset('icons/icon-192x192.png') }}">

    @stack('styles')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
</head>

<body>

    {{-- Top app bar, hidden on login --}}
    @unless (Route::is('login'))
        <header class="app-bar">
            <span class="app-bar__logo"><i class="bi bi-scooter"></i></span>
            <span class="app-bar__title">MotoRent</span>
            <span class="app-bar__date">{{ now()->format('d/m/Y') }}</span>
        </header>
    @endunless

    <div class="container">
        @yield('content')
    </div>

    {{-- Bottom nav, hidden on login --}}
    @unless (Route::is('login'))
        @include('footer')
    @endunless

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

    @stack('scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
