@extends('layouts.app')

@section('title', 'Контакты')

@section('content')
    <div class="mx-auto max-w-3xl">
        <div class="rounded-2xl border border-stone-200 bg-white p-8 shadow-sm sm:p-12">
            <div class="mb-6 text-5xl">📞</div>
            <h1 class="text-3xl font-bold text-stone-900">Контакты</h1>
            <p class="mt-4 text-lg text-stone-600">
                Есть вопрос или хотите предложить свой рецепт? Свяжитесь с нами — мы будем рады!
            </p>

            <div class="mt-10 space-y-4">
                <div class="flex items-center gap-4 rounded-xl bg-stone-50 p-5">
                    <span class="text-2xl">📱</span>
                    <div>
                        <p class="text-sm text-stone-500">Телефон</p>
                        <p class="font-medium text-stone-800">+7 (123) 456-78-90</p>
                    </div>
                </div>
                <div class="flex items-center gap-4 rounded-xl bg-stone-50 p-5">
                    <span class="text-2xl">✉️</span>
                    <div>
                        <p class="text-sm text-stone-500">Email</p>
                        <p class="font-medium text-stone-800">hello@my-recipes.ru</p>
                    </div>
                </div>
                <div class="flex items-center gap-4 rounded-xl bg-stone-50 p-5">
                    <span class="text-2xl">📍</span>
                    <div>
                        <p class="text-sm text-stone-500">Адрес</p>
                        <p class="font-medium text-stone-800">Москва, ул. Кулинарная, 1</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
