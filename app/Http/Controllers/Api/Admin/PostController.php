<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\PostSlug;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $query = Post::with('categories:id,name');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('q')) {
            $query->where('title', 'like', '%' . $request->q . '%');
        }

        return response()->json($query->paginate(15));
    }

    public function show(Post $post)
    {
        return response()->json($post->load('categories', 'slugs'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:posts,slug',
            'content' => 'required|string',
            'status' => 'required|in:draft,scheduled,published',
            'published_at' => 'nullable|date',
            'meta_title' => 'nullable|string|max:70',
            'meta_description' => 'nullable|string|max:170',
            'focus_keyword' => 'nullable|string',
            'category_ids' => 'nullable|array',
            'category_ids.*' => 'exists:post_categories,id',
            'author_name' => 'nullable|string',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title'], '-', 'ar');
        }

        if ($validated['status'] === 'published' && empty($validated['published_at'])) {
            $validated['published_at'] = now();
        }

        $post = Post::create($validated);

        if (!empty($validated['category_ids'])) {
            $post->categories()->sync($validated['category_ids']);
        }

        return response()->json([
            'message' => 'تم إنشاء المقال بنجاح',
            'post' => $post
        ], 201);
    }

    public function update(Request $request, Post $post)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:posts,slug,'.$post->id,
            'content' => 'required|string',
            'status' => 'required|in:draft,scheduled,published',
            'published_at' => 'nullable|date',
            'meta_title' => 'nullable|string|max:70',
            'meta_description' => 'nullable|string|max:170',
            'focus_keyword' => 'nullable|string',
            'category_ids' => 'nullable|array',
            'author_name' => 'nullable|string',
        ]);

        if (!empty($validated['slug']) && $validated['slug'] !== $post->slug) {
            PostSlug::create([
                'post_id' => $post->id,
                'old_slug' => $post->slug,
            ]);
        } elseif (empty($validated['slug'])) {
            $validated['slug'] = $post->slug; // Keep old if not provided
        }

        // Logic to not change lastmod unless actual content changes could be handled mostly by updated_at inherently.
        // But for Sitemap: updated_at of Post IS the lastmod.

        $post->update($validated);

        if (isset($validated['category_ids'])) {
            $post->categories()->sync($validated['category_ids']);
        }

        return response()->json([
            'message' => 'تم تحديث المقال بنجاح',
            'post' => $post
        ]);
    }

    public function destroy(Post $post)
    {
        $post->delete();
        return response()->json(['message' => 'تم حذف المقال']);
    }
}
