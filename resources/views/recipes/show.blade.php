@extends('layouts.app')

@section('title', $recipe->title)

@section('content')
    <nav class="mb-6 text-sm text-stone-500">
        <a href="{{ route('recipes.index') }}" class="hover:text-orange-600">Каталог</a>
        <span class="mx-2">/</span>
        <span class="text-stone-800">{{ $recipe->title }}</span>
    </nav>

    <article class="overflow-hidden rounded-2xl border border-stone-200 bg-white shadow-sm">
        <div class="flex flex-col gap-6 border-b border-stone-100 bg-gradient-to-br from-orange-50 to-amber-50 p-6 sm:flex-row sm:items-center sm:p-10">
            <div class="flex h-28 w-28 shrink-0 items-center justify-center rounded-2xl bg-white text-6xl shadow-sm">
                {{ $recipe->emoji }}
            </div>
            <div>
                <div class="mb-3 flex flex-wrap gap-2">
                    <span class="rounded-full bg-orange-100 px-3 py-1 text-sm font-medium text-orange-800">
                        {{ $recipe->category }}
                    </span>
                    <span class="rounded-full bg-stone-100 px-3 py-1 text-sm font-medium text-stone-600">
                        {{ $recipe->difficulty_label }}
                    </span>
                </div>
                <h1 class="text-3xl font-bold text-stone-900 sm:text-4xl">{{ $recipe->title }}</h1>
                <p class="mt-3 max-w-2xl text-lg text-stone-600">{{ $recipe->description }}</p>
            </div>
        </div>

        <div class="grid gap-4 border-b border-stone-100 p-6 sm:grid-cols-4 sm:p-8">
            <div class="rounded-xl bg-stone-50 p-4 text-center">
                <p class="text-2xl">🔪</p>
                <p class="mt-1 text-xs uppercase tracking-wide text-stone-400">Подготовка</p>
                <p class="text-lg font-semibold text-stone-800">{{ $recipe->prep_time }} мин</p>
            </div>
            <div class="rounded-xl bg-stone-50 p-4 text-center">
                <p class="text-2xl">🔥</p>
                <p class="mt-1 text-xs uppercase tracking-wide text-stone-400">Готовка</p>
                <p class="text-lg font-semibold text-stone-800">{{ $recipe->cook_time }} мин</p>
            </div>
            <div class="rounded-xl bg-stone-50 p-4 text-center">
                <p class="text-2xl">⏱</p>
                <p class="mt-1 text-xs uppercase tracking-wide text-stone-400">Всего</p>
                <p class="text-lg font-semibold text-stone-800">{{ $recipe->total_time }} мин</p>
            </div>
            <div class="rounded-xl bg-stone-50 p-4 text-center">
                <p class="text-2xl">👥</p>
                <p class="mt-1 text-xs uppercase tracking-wide text-stone-400">Порций</p>
                <p class="text-lg font-semibold text-stone-800">{{ $recipe->servings }}</p>
            </div>
        </div>

        <div class="grid gap-8 p-6 sm:p-8 lg:grid-cols-2">
            <section>
                <h2 class="mb-4 flex items-center gap-2 text-xl font-semibold text-stone-900">
                    <span>🛒</span> Ингредиенты
                </h2>
                <ul class="space-y-2">
                    @foreach ($recipe->ingredients as $ingredient)
                        <li class="flex items-start gap-3 rounded-lg bg-stone-50 px-4 py-3 text-stone-700">
                            <span class="mt-1.5 h-2 w-2 shrink-0 rounded-full bg-orange-400"></span>
                            {{ $ingredient }}
                        </li>
                    @endforeach
                </ul>
            </section>

            <section>
                <h2 class="mb-4 flex items-center gap-2 text-xl font-semibold text-stone-900">
                    <span>📝</span> Приготовление
                </h2>
                <ol class="space-y-4">
                    @foreach ($recipe->steps as $index => $step)
                        <li class="flex gap-4">
                            <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-orange-500 text-sm font-bold text-white">
                                {{ $index + 1 }}
                            </span>
                            <p class="pt-1 text-stone-700">{{ $step }}</p>
                        </li>
                    @endforeach
                </ol>
            </section>
        </div>
    </article>

    @if ($related->isNotEmpty())
        <section class="mt-12">
            <h2 class="mb-6 text-xl font-semibold text-stone-900">Похожие рецепты</h2>
            <div class="grid gap-4 sm:grid-cols-3">
                @foreach ($related as $item)
                    <a href="{{ route('recipes.show', $item) }}"
                       class="flex items-center gap-4 rounded-xl border border-stone-200 bg-white p-4 transition hover:border-orange-300 hover:shadow-sm">
                        <span class="text-3xl">{{ $item->emoji }}</span>
                        <div>
                            <p class="font-medium text-stone-900">{{ $item->title }}</p>
                            <p class="text-sm text-stone-500">{{ $item->total_time }} мин</p>
                        </div>
                    </a>
                @endforeach
            </div>
        </section>
    @endif

    <div class="mt-8">
        <a href="{{ route('recipes.index') }}"
           class="inline-flex items-center gap-2 rounded-xl border border-stone-200 bg-white px-5 py-2.5 text-sm font-medium text-stone-700 transition hover:bg-stone-50">
            ← Вернуться к каталогу
        </a>
    </div>
@endsection
