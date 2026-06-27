{{-- Общее подключение CSS/JS. Пути /build/... — относительные, чтобы работало на Render без APP_URL --}}
@if (file_exists(public_path('hot')))
    @fonts
    @vite(['resources/css/app.css', 'resources/js/app.js'])
@elseif (file_exists(public_path('build/manifest.json')))
    @php
        $viteManifest = json_decode(file_get_contents(public_path('build/manifest.json')), true);
        $fontsManifestPath = public_path('build/fonts-manifest.json');
        $fontsManifest = file_exists($fontsManifestPath)
            ? json_decode(file_get_contents($fontsManifestPath), true)
            : null;
    @endphp

    @if (! empty($fontsManifest['style']['file']))
        <link rel="stylesheet" href="/build/{{ $fontsManifest['style']['file'] }}">
    @endif

    @if (! empty($viteManifest['resources/css/app.css']['file']))
        <link rel="stylesheet" href="/build/{{ $viteManifest['resources/css/app.css']['file'] }}">
    @endif

    @if (! empty($viteManifest['resources/js/app.js']['file']))
        <script type="module" src="/build/{{ $viteManifest['resources/js/app.js']['file'] }}"></script>
    @endif
@else
    {{-- Fallback, если npm run build ещё не выполнялся --}}
    @fonts
    <script src="https://cdn.tailwindcss.com"></script>
@endif
