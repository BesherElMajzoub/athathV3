<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProgrammaticPage;
use App\Services\Seo\ProgrammaticPageGenerator;
use App\Services\Seo\SeoGuardrails;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProgrammaticPageController extends Controller
{
    public function __construct(
        private ProgrammaticPageGenerator $generator,
        private SeoGuardrails $guardrails
    ) {}

    public function index(Request $request): View
    {
        $query = ProgrammaticPage::orderByDesc('created_at');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $pages = $query->paginate(25)->withQueryString();

        return view('admin.programmatic.index', compact('pages'));
    }

    public function create(): View
    {
        return view('admin.programmatic.form', ['page' => new ProgrammaticPage()]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validatePage($request);

        // Generate content blocks if requested
        if ($request->boolean('auto_generate')) {
            $data['content_blocks'] = $this->generator->buildContentBlocks($data);
            $data['last_generated_at'] = now();
        }

        $page = ProgrammaticPage::create($data);

        return redirect()->route('admin.programmatic.edit', $page)
            ->with('success', 'تم إنشاء الصفحة بنجاح.');
    }

    public function edit(ProgrammaticPage $programmaticPage): View
    {
        return view('admin.programmatic.form', ['page' => $programmaticPage]);
    }

    public function update(Request $request, ProgrammaticPage $programmaticPage): RedirectResponse
    {
        $data = $this->validatePage($request, $programmaticPage->id);
        $programmaticPage->update($data);

        return redirect()->route('admin.programmatic.edit', $programmaticPage)
            ->with('success', 'تم التحديث بنجاح.');
    }

    public function destroy(ProgrammaticPage $programmaticPage): RedirectResponse
    {
        $programmaticPage->delete();
        return redirect()->route('admin.programmatic.index')->with('success', 'تم الحذف بنجاح.');
    }

    public function publish(ProgrammaticPage $programmaticPage): RedirectResponse
    {
        // Run guardrails check before publishing
        $errors = $this->guardrails->checkProgrammaticPage($programmaticPage);

        if (!empty($errors)) {
            return redirect()->back()->withErrors($errors);
        }

        $programmaticPage->update(['status' => 'published']);

        return redirect()->route('admin.programmatic.index')
            ->with('success', 'تم نشر الصفحة بنجاح.');
    }

    public function bulkPublish(Request $request): RedirectResponse
    {
        $ids = $request->validate(['ids' => 'required|array', 'ids.*' => 'integer'])['ids'];

        $published = 0;
        foreach (ProgrammaticPage::whereIn('id', $ids)->where('status', 'draft')->get() as $page) {
            $errors = $this->guardrails->checkProgrammaticPage($page);
            if (empty($errors)) {
                $page->update(['status' => 'published']);
                $published++;
            }
        }

        return redirect()->back()->with('success', "تم نشر {$published} صفحة بنجاح.");
    }

    public function regenerate(ProgrammaticPage $programmaticPage): RedirectResponse
    {
        $data = $programmaticPage->toArray();
        $programmaticPage->update([
            'content_blocks'   => $this->generator->buildContentBlocks($data),
            'last_generated_at' => now(),
        ]);

        return redirect()->back()->with('success', 'تم إعادة توليد المحتوى بنجاح.');
    }

    private function validatePage(Request $request, ?int $ignoreId = null): array
    {
        return $request->validate([
            'slug'             => 'required|string|max:255|unique:programmatic_pages,slug' . ($ignoreId ? ",$ignoreId" : ''),
            'city'             => 'nullable|string|max:100',
            'primary_keyword'  => 'required|string|max:255',
            'title'            => 'required|string|max:255',
            'meta_title'       => 'required|string|max:70',
            'meta_description' => 'required|string|max:170',
            'canonical_url'    => 'nullable|url|max:500',
            'status'           => 'required|in:draft,published',
            'indexable'        => 'boolean',
            'content_blocks'   => 'nullable|array',
        ]);
    }
}
