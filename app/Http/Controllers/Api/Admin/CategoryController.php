<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\PostCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
    {
        return response()->json(PostCategory::all());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:post_categories,slug',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name'], '-', 'ar');
        }

        $category = PostCategory::create($validated);
        return response()->json(['message' => 'تم إضافة التصنيف', 'category' => $category], 201);
    }

    public function update(Request $request, PostCategory $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:post_categories,slug,'.$category->id,
        ]);

        $category->update($validated);
        return response()->json(['message' => 'تم التحديث', 'category' => $category]);
    }

    public function destroy(PostCategory $category)
    {
        $category->delete();
        return response()->json(['message' => 'تم החذف']);
    }
}
