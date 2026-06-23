@extends('layouts.app')

@section('title', 'О нас')

@section('content')
    <div class="mx-auto max-w-3xl">
        <div class="rounded-2xl border border-stone-200 bg-white p-8 shadow-sm sm:p-12">
            <div class="mb-6 text-5xl">👨‍🍳</div>
            <h1 class="text-3xl font-bold text-stone-900">О нашем проекте</h1>
            <p class="mt-4 text-lg leading-relaxed text-stone-600">
                «Мои рецепты» — это простой и удобный сайт с домашними блюдами. Мы собираем проверенные рецепты
                с понятными инструкциями, чтобы готовить было легко даже начинающим.
            </p>

            <div class="mt-10 grid gap-6 sm:grid-cols-3">
                <div class="rounded-xl bg-orange-50 p-5 text-center">
                    <p class="text-3xl">📖</p>
                    <p class="mt-2 font-semibold text-stone-800">Понятно</p>
                    <p class="mt-1 text-sm text-stone-500">Пошаговые инструкции без лишних слов</p>
                </div>
                <div class="rounded-xl bg-orange-50 p-5 text-center">
                    <p class="text-3xl">🏠</p>
                    <p class="mt-2 font-semibold text-stone-800">Домашнее</p>
                    <p class="mt-1 text-sm text-stone-500">Рецепты из простых продуктов</p>
                </div>
                <div class="rounded-xl bg-orange-50 p-5 text-center">
                    <p class="text-3xl">❤️</p>
                    <p class="mt-2 font-semibold text-stone-800">С любовью</p>
                    <p class="mt-1 text-sm text-stone-500">К каждому блюду и детали</p>
                </div>
            </div>
        </div>
    </div>
@endsection
