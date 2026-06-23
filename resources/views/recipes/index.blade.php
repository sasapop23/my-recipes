@extends('layouts.app')

@section('title', 'Каталог рецептов')

@section('content')
    <section class="mb-10">
        <div class="rounded-2xl bg-gradient-to-br from-orange-500 to-amber-600 px-6 py-10 text-white shadow-lg sm:px-10">
            <h1 class="text-3xl font-bold tracking-tight sm:text-4xl">Домашние рецепты</h1>
            <p class="mt-3 max-w-xl text-lg text-orange-50">
                Простые и понятные блюда для каждого дня. Выберите рецепт — и готовьте с удовольствием.
            </p>
        </div>
    </section>

    <section class="mb-8">
        <form action="{{ route('recipes.index') }}" method="GET" class="flex flex-col gap-4 sm:flex-row">
            <div class="relative flex-1">
                <span class="pointer-events-none absolute inset-y-0 left-3 flex items-center text-stone-400">🔍</span>
                <input
                    type="search"
                    name="q"
                    value="{{ $search ?? '' }}"
                    placeholder="Поиск по названию или описанию..."
                    class="w-full rounded-xl border border-stone-200 bg-white py-3 pl-10 pr-4 text-stone-800 shadow-sm outline-none transition focus:border-orange-400 focus:ring-2 focus:ring-orange-200"
                >
            </div>

            <select
                name="category"
                onchange="this.form.submit()"
                class="rounded-xl border border-stone-200 bg-white px-4 py-3 text-stone-800 shadow-sm outline-none transition focus:border-orange-400 focus:ring-2 focus:ring-orange-200 sm:w-52"
            >
                <option value="">Все категории</option>
                @foreach ($categories as $cat)
                    <option value="{{ $cat }}" @selected(($category ?? '') === $cat)>{{ $cat }}</option>
                @endforeach
            </select>

            <button type="submit"
                    class="rounded-xl bg-stone-900 px-6 py-3 font-medium text-white shadow-sm transition hover:bg-stone-800">
                Найти
            </button>
        </form>
    </section>

    @if ($recipes->isEmpty())
        <div class="rounded-2xl border border-dashed border-stone-300 bg-white px-6 py-16 text-center">
            <p class="text-5xl">🤷</p>
            <h2 class="mt-4 text-xl font-semibold text-stone-800">Рецепты не найдены</h2>
            <p class="mt-2 text-stone-500">Попробуйте изменить запрос или выбрать другую категорию.</p>
            <a href="{{ route('recipes.index') }}"
               class="mt-6 inline-block rounded-xl bg-orange-500 px-5 py-2.5 font-medium text-white transition hover:bg-orange-600">
                Показать все рецепты
            </a>
        </div>
    @else
        <p class="mb-4 text-sm text-stone-500">Найдено рецептов: {{ $recipes->count() }}</p>

        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ($recipes as $recipe)
                <article class="group flex flex-col overflow-hidden rounded-2xl border border-stone-200 bg-white shadow-sm transition hover:-translate-y-1 hover:shadow-md">
                    <div class="flex h-36 items-center justify-center bg-gradient-to-br from-orange-50 to-amber-50 text-6xl">
                        {{ $recipe->emoji }}
                    </div>

                    <div class="flex flex-1 flex-col p-5">
                        <div class="mb-2 flex items-center gap-2">
                            <span class="rounded-full bg-orange-100 px-2.5 py-0.5 text-xs font-medium text-orange-800">
                                {{ $recipe->category }}
                            </span>
                            <span class="rounded-full bg-stone-100 px-2.5 py-0.5 text-xs font-medium text-stone-600">
                                {{ $recipe->difficulty_label }}
                            </span>
                        </div>

                        <h2 class="text-lg font-semibold text-stone-900 group-hover:text-orange-700">
                            <a href="{{ route('recipes.show', $recipe) }}" class="hover:underline">
                                {{ $recipe->title }}
                            </a>
                        </h2>

                        <p class="mt-2 line-clamp-2 flex-1 text-sm text-stone-500">
                            {{ $recipe->description }}
                        </p>

                        <div class="mt-4 flex items-center gap-4 text-xs text-stone-400">
                            <span>⏱ {{ $recipe->total_time }} мин</span>
                            <span>👥 {{ $recipe->servings }} порц.</span>
                        </div>

                        <a href="{{ route('recipes.show', $recipe) }}"
                           class="mt-4 inline-flex items-center justify-center rounded-xl bg-orange-500 px-4 py-2.5 text-sm font-medium text-white transition hover:bg-orange-600">
                            Смотреть рецепт →
                        </a>
                    </div>
                </article>
            @endforeach
        </div>
    @endif
@endsection
