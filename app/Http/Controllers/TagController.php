<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TagController extends Controller
{
    public function store(Request $request)
    {
        try {
            $request->validate([
                'name_uz' => 'required|string|max:255|unique:tags,name_uz',
                'name_ru' => 'required|string|max:255|unique:tags,name_ru',
                'name_en' => 'required|string|max:255|unique:tags,name_en',
                'slug' => 'nullable|string|max:255|unique:tags,slug',
            ]);

            // Agar slug kiritilmagan bo'lsa, avtomatik yaratamiz
            $slug = $request->slug ?? Str::slug($request->name_en);

            $tag = Tag::create([
                'name_uz' => $request->name_uz,
                'name_ru' => $request->name_ru,
                'name_en' => $request->name_en,
                'slug' => $slug,
            ]);

            return redirect()->back()->with('success', __('words.tag_created_successfully'));

        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->validator)->withInput();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', __('words.error_occurred') . ': ' . $e->getMessage());
        }
    }
}