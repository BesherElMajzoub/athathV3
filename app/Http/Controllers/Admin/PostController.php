<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\PostCategory;
use App\Models\PostSlug;
use App\Services\Seo\SeoContentAnalyzer;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class PostController extends Controller
{
    public function __construct(private SeoContentAnalyzer $analyzer) {}

    // ----------------------------------------------------------------
    // Index
    // ----------------------------------------------------------------

    public function index(Request $request): View
    {
        $query = Post::with('categories')
            ->orderByDesc('created_at');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        $posts = $query->paginate(20)->withQueryString();
        $categories = PostCategory::all();

        return view('admin.posts.index', compact('posts', 'categories'));
    }

    // ----------------------------------------------------------------
    // Create
    // ----------------------------------------------------------------

    public function create(): View
    {
        $post = new Post(['status' => 'draft', 'schema_type' => 'Article']);
        $categories = PostCategory::orderBy('name')->get();
        $allCategories = $categories;
        $selectedCategories = [];

        return view('admin.posts.form', compact('post', 'categories', 'allCategories', 'selectedCategories'));
    }

    // ----------------------------------------------------------------
    // Store
    // ----------------------------------------------------------------

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validatePost($request);
        $data['slug'] = $this->generateUniqueSlug($data['slug'] ?? $data['title']);
        $data['reading_time'] = $this->analyzer->calculateReadingTime($data['content'] ?? '');

        if ($request->hasFile('featured_image')) {
            $data['featured_image'] = $request->file('featured_image')->store('posts', 'public');
        }

        $post = Post::create($data);

        if ($request->filled('categories')) {
            $post->categories()->sync(
                PostCategory::whereIn('id', $request->categories)->pluck('id')
            );
        }

        return redirect()->route('admin.posts.edit', $post)
            ->with('success', 'تم إنشاء المقال بنجاح.');
    }

    // ----------------------------------------------------------------
    // Edit
    // ----------------------------------------------------------------

    public function edit(Post $post): View
    {
        $post->load('categories', 'slugs');
        $allCategories = PostCategory::orderBy('name')->get();
        $selectedCategories = $post->categories->pluck('id')->toArray();
        $seoChecks = $this->analyzer->analyze($post);

        return view('admin.posts.form', compact('post', 'allCategories', 'selectedCategories', 'seoChecks'));
    }

    // ----------------------------------------------------------------
    // Update
    // ----------------------------------------------------------------

    public function update(Request $request, Post $post): RedirectResponse
    {
        $data = $this->validatePost($request, $post->id);
        $newSlug = $this->generateUniqueSlug($data['slug'] ?? $post->slug, $post->id);

        // Track slug change for 301 redirect
        if ($newSlug !== $post->slug) {
            PostSlug::create([
                'post_id'    => $post->id,
                'old_slug'   => $post->slug,
                'created_at' => now(),
            ]);
        }

        $data['slug'] = $newSlug;
        $data['reading_time'] = $this->analyzer->calculateReadingTime($data['content'] ?? $post->content);

        if ($request->hasFile('featured_image')) {
            // Delete old image
            if ($post->featured_image) {
                Storage::disk('public')->delete($post->featured_image);
            }
            $data['featured_image'] = $request->file('featured_image')->store('posts', 'public');
        }

        $post->update($data);

        if ($request->has('categories')) {
            $post->categories()->sync($request->categories ?? []);
        } else {
            $post->categories()->detach();
        }

        return redirect()->route('admin.posts.edit', $post)
            ->with('success', 'تم تحديث المقال بنجاح.');
    }

    // ----------------------------------------------------------------
    // Destroy
    // ----------------------------------------------------------------

    public function destroy(Post $post): RedirectResponse
    {
        if ($post->featured_image) {
            Storage::disk('public')->delete($post->featured_image);
        }
        $post->delete();

        return redirect()->route('admin.posts.index')
            ->with('success', 'تم حذف المقال بنجاح.');
    }

    // ----------------------------------------------------------------
    // Publish Now
    // ----------------------------------------------------------------

    public function publishNow(Post $post): RedirectResponse
    {
        $post->update([
            'status'       => 'published',
            'published_at' => now(),
        ]);

        return redirect()->route('admin.posts.edit', $post)
            ->with('success', 'تم نشر المقال فوراً.');
    }

    // ----------------------------------------------------------------
    // Schedule
    // ----------------------------------------------------------------

    public function schedule(Request $request, Post $post): RedirectResponse
    {
        $request->validate([
            'publish_at' => 'required|date|after:now',
        ]);

        $post->update([
            'status'       => 'scheduled',
            'published_at' => Carbon::parse($request->publish_at),
        ]);

        return redirect()->route('admin.posts.edit', $post)
            ->with('success', 'تمت جدولة المقال بنجاح.');
    }

    // ----------------------------------------------------------------
    // Duplicate
    // ----------------------------------------------------------------

    public function duplicate(Post $post): RedirectResponse
    {
        $newPost = $post->replicate();
        $newPost->title = $post->title . ' (نسخة)';
        $newPost->slug = $this->generateUniqueSlug($post->slug . '-copy');
        $newPost->status = 'draft';
        $newPost->published_at = null;
        $newPost->save();

        $newPost->categories()->sync($post->categories->pluck('id'));

        return redirect()->route('admin.posts.edit', $newPost)
            ->with('success', 'تم تكرار المقال بنجاح.');
    }

    // ----------------------------------------------------------------
    // Helpers
    // ----------------------------------------------------------------

    private function validatePost(Request $request, ?int $ignoreId = null): array
    {
        $publishedAtRule = 'nullable|date';
        if ($request->input('status') === 'published') {
            $publishedAtRule = 'required|date';
        }

        return $request->validate([
            'title'                       => 'required|string|max:255',
            'slug'                        => 'nullable|string|max:255',
            'excerpt'                     => 'nullable|string',
            'content'                     => 'required|string',
            'featured_image'              => 'nullable|image|max:5120',
            'featured_image_alt'          => 'nullable|string|max:255',
            'status'                      => 'required|in:draft,scheduled,published',
            'published_at'                => $publishedAtRule,
            'canonical_url'               => 'nullable|url|max:500',
            'meta_title'                  => 'nullable|string|max:70',
            'meta_description'            => 'nullable|string|max:170',
            'focus_keyword'               => 'nullable|string|max:100',
            'schema_type'                 => 'nullable|string|in:Article,FAQPage,BlogPosting,NewsArticle',
            'schema_faq'                  => 'nullable|array',
            'schema_faq.*.question'       => 'required_with:schema_faq|string',
            'schema_faq.*.answer'         => 'required_with:schema_faq|string',
            'author_name'                 => 'nullable|string|max:100',
            'enable_auto_internal_links'  => 'boolean',
            'categories'                  => 'nullable|array',
            'categories.*'               => 'integer|exists:post_categories,id',
        ]);
    }

    private function generateUniqueSlug(string $input, ?int $ignoreId = null): string
    {
        $slug = $this->slugify($input);
        $base = $slug;
        $i = 1;

        while (true) {
            $query = Post::where('slug', $slug);
            if ($ignoreId) {
                $query->where('id', '!=', $ignoreId);
            }
            if (!$query->exists()) {
                break;
            }
            $slug = $base . '-' . $i++;
        }

        return $slug;
    }

    /**
     * Supports Arabic + Latin slugification.
     * Arabic chars are kept, spaces become hyphens, special chars stripped.
     */
    private function slugify(string $text): string
    {
        // Try Laravel's built-in first (handles latin well)
        $slug = Str::slug($text, '-', 'ar');

        // If result is empty (pure Arabic), do manual slugification
        if (empty($slug)) {
            $slug = preg_replace('/\s+/', '-', trim($text));
            $slug = preg_replace('/[^ء-ي0-9a-z\-]/u', '', mb_strtolower($slug));
            $slug = preg_replace('/-+/', '-', $slug);
            $slug = trim($slug, '-');
        }

        return $slug ?: 'post';
    }
}
