<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Рецепты') — {{ config('app.name', 'Мои рецепты') }}</title>

    @include('layouts.partials.head-assets')
</head>
<body class="min-h-screen bg-stone-50 text-stone-800 antialiased">
    <header class="sticky top-0 z-50 border-b border-stone-200 bg-white/90 backdrop-blur-md">
        <div class="mx-auto flex max-w-6xl items-center justify-between gap-4 px-4 py-4 sm:px-6">
            <a href="{{ route('recipes.index') }}" class="flex items-center gap-2 text-lg font-semibold text-stone-900">
                <span class="text-2xl">🍳</span>
                <span>Мои рецепты</span>
            </a>

            <nav class="flex flex-wrap items-center justify-end gap-1 sm:gap-2">
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

                @guest
                    <a href="{{ route('login') }}"
                       class="rounded-lg px-3 py-2 text-sm font-medium text-stone-600 transition hover:bg-stone-100 hover:text-stone-900">
                        Вход
                    </a>
                    <a href="{{ route('register') }}"
                       class="rounded-lg bg-orange-500 px-3 py-2 text-sm font-medium text-white transition hover:bg-orange-600">
                        Регистрация
                    </a>
                @else
                    <span class="hidden px-2 text-sm text-stone-500 sm:inline">{{ Auth::user()->name }}</span>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit"
                                class="rounded-lg px-3 py-2 text-sm font-medium text-stone-600 transition hover:bg-stone-100 hover:text-stone-900">
                            Выйти
                        </button>
                    </form>
                @endguest
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
