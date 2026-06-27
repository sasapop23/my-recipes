<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Рецепты') — {{ config('app.name', 'Мои рецепты') }}</title>

    @fonts

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif

</head>
<body class="min-h-screen bg-stone-50 text-stone-800 antialiased">
    <header class="sticky top-0 z-50 border-b border-stone-200 bg-white/90 backdrop-blur-md">
        <div class="mx-auto flex max-w-6xl items-center justify-between gap-4 px-4 py-4 sm:px-6">
            <a href="{{ route('recipes.index') }}" class="flex items-center gap-2 text-lg font-semibold text-stone-900">
                <span class="text-2xl">🍳</span>
                <span>Мои рецепты</span>
            </a>

            <nav class="flex items-center gap-1 sm:gap-2">
                <a href="{{ route('recipes.index') }}"
                   class="rounded-lg px-3 py-2 text-sm font-medium transition {{ request()->routeIs('recipes.*') ? 'bg-orange-100 text-orange-800' : 'text-stone-600 hover:bg-stone-100 hover:text-stone-900' }}">
                    Каталог
                </a>
                <a href="{{ route('about') }}"
                   class="rounded-lg px-3 py-2 text-sm font-medium transition {{ request()->routeIs('about') ? 'bg-orange-100 text-orange-800' : 'text-stone-600 hover:bg-stone-100 hover:text-stone-900' }}">
                    О нас
                </a>
                <a href="{{ route('contacts') }}"
                   class="rounded-lg px-3 py-2 text-sm font-medium transition {{ request()->routeIs('contacts') ? 'bg-orange-100 text-orange-800' : 'text-stone-600 hover:bg-stone-100 hover:text-stone-900' }}">
                    Контакты
                </a>
            </nav>
        </div>
    </header>

    <main class="mx-auto max-w-6xl px-4 py-8 sm:px-6">
        @yield('content')
    </main>

    <footer class="border-t border-stone-200 bg-white">
        <div class="mx-auto flex max-w-6xl flex-col items-center justify-between gap-2 px-4 py-6 text-sm text-stone-500 sm:flex-row sm:px-6">
            <p>© {{ date('Y') }} Мои рецепты — домашняя кулинария</p>
            <p>Сделано с любовью к вкусной еде</p>
        </div>
    </footer>
</body>
</html>
