<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function store(Request $request)
    {
        try {
            $request->validate([
                'name_uz' => 'required|string|max:255|unique:categories,name_uz',
                'name_ru' => 'required|string|max:255|unique:categories,name_ru',
                'name_en' => 'required|string|max:255|unique:categories,name_en',
                'slug' => 'nullable|string|max:255|unique:categories,slug',
            ]);

            // Agar slug kiritilmagan bo'lsa, avtomatik yaratamiz
            $slug = $request->slug ?? Str::slug($request->name_en);

            $category = Category::create([
                'name_uz' => $request->name_uz,
                'name_ru' => $request->name_ru,
                'name_en' => $request->name_en,
                'slug' => $slug,
            ]);

            app(\App\Services\PostService::class)->clearPostCache();

            return redirect()->back()->with('success', __('words.category_created_successfully'));

        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->validator)->withInput();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', __('words.error_occurred') . ': ' . $e->getMessage());
        }
    }
}