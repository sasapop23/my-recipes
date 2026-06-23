<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RecipeController extends Controller
{
    public function index(Request $request): View
    {
        $query = Recipe::query()->orderBy('title');

        if ($search = $request->string('q')->trim()->toString()) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhere('category', 'like', "%{$search}%");
            });
        }

        if ($category = $request->string('category')->trim()->toString()) {
            $query->where('category', $category);
        }

        $recipes = $query->get();
        $categories = Recipe::query()
            ->select('category')
            ->distinct()
            ->orderBy('category')
            ->pluck('category');

        return view('recipes.index', compact('recipes', 'categories', 'search', 'category'));
    }

    public function show(Recipe $recipe): View
    {
        $related = Recipe::query()
            ->where('category', $recipe->category)
            ->where('id', '!=', $recipe->id)
            ->limit(3)
            ->get();

        return view('recipes.show', compact('recipe', 'related'));
    }
}
