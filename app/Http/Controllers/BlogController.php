<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\PostCategory;
use App\Models\PostSlug;
use App\Services\Seo\InternalLinker;
use App\Services\Seo\SchemaBuilder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BlogController extends Controller
{
    public function __construct(
        private InternalLinker $linker,
        private SchemaBuilder $schemaBuilder
    ) {}

    // ----------------------------------------------------------------
    // Blog Index
    // ----------------------------------------------------------------

    public function index(Request $request): View
    {
        $query = Post::published()
            ->with(['categories:id,name,slug'])
            ->select('id', 'title', 'slug', 'excerpt', 'featured_image', 'featured_image_alt',
                     'published_at', 'reading_time', 'author_name', 'status');

        // Filter by category
        if ($request->filled('category')) {
            $query->whereHas('categories', fn($q) => $q->where('slug', $request->category));
        }

        $posts = $query->orderByDesc('published_at')->paginate(12)->withQueryString();
        $categories = PostCategory::withCount(['posts' => fn($q) => $q->published()])->get();

        $seo = [
            'title'       => 'المدونة - أثاث مستعمل',
            'description' => 'اقرأ أحدث المقالات والنصائح حول شراء وبيع الأثاث المستعمل',
            'canonical'   => url('/blog'),
        ];

        return view('blog.index', compact('posts', 'categories', 'seo'));
    }

    // ----------------------------------------------------------------
    // Blog Show
    // ----------------------------------------------------------------

    public function show(string $slug): View|RedirectResponse
    {
        // 1. Check current published post
        $post = Post::published()
            ->where('slug', $slug)
            ->with(['categories:id,name,slug'])
            ->first();

        if ($post) {
            // Apply internal linking if enabled
            if ($post->enable_auto_internal_links) {
                $post->content = $this->linker->process($post->content);
            }

            $schema = $this->schemaBuilder->forPost($post);
            $breadcrumbSchema = $this->schemaBuilder->breadcrumb([
                ['name' => 'الرئيسية', 'url' => url('/')],
                ['name' => 'المدونة', 'url' => url('/blog')],
                ['name' => $post->title, 'url' => url('/blog/' . $post->slug)],
            ]);

            // Related posts (same category, excluding current)
            $relatedPosts = Post::published()
                ->whereHas('categories', fn($q) => $q->whereIn(
                    'post_categories.id',
                    $post->categories->pluck('id')
                ))
                ->where('id', '!=', $post->id)
                ->select('id', 'title', 'slug', 'excerpt', 'featured_image', 'published_at')
                ->orderByDesc('published_at')
                ->limit(3)
                ->get();

            return view('blog.show', compact('post', 'schema', 'breadcrumbSchema', 'relatedPosts'));
        }

        // 2. Check old slug for 301 redirect
        $oldSlug = PostSlug::where('old_slug', $slug)->with('post')->first();

        if ($oldSlug && $oldSlug->post) {
            $currentPost = $oldSlug->post;
            // Only redirect if the target post is published
            if ($currentPost->isPubliclyVisible()) {
                return redirect()->to('/blog/' . $currentPost->slug, 301);
            }
        }

        // 3. Check if it exists but is not published → 404
        abort(404);
    }
}
