<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SeoKeywordCluster;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SeoClusterController extends Controller
{
    public function index(): View
    {
        $clusters = SeoKeywordCluster::withCount('keywords')->orderByDesc('created_at')->paginate(20);
        return view('admin.seo.clusters.index', compact('clusters'));
    }

    public function create(): View
    {
        return view('admin.seo.clusters.form', ['cluster' => new SeoKeywordCluster()]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'cluster_name'    => 'required|string|max:255',
            'primary_keyword' => 'required|string|max:255',
            'language'        => 'required|string|in:ar,en',
        ]);

        SeoKeywordCluster::create($data);

        return redirect()->route('admin.seo.clusters.index')->with('success', 'تم إنشاء المجموعة بنجاح.');
    }

    public function edit(SeoKeywordCluster $cluster): View
    {
        $cluster->load('keywords');
        return view('admin.seo.clusters.form', compact('cluster'));
    }

    public function update(Request $request, SeoKeywordCluster $cluster): RedirectResponse
    {
        $data = $request->validate([
            'cluster_name'    => 'required|string|max:255',
            'primary_keyword' => 'required|string|max:255',
            'language'        => 'required|string|in:ar,en',
        ]);

        $cluster->update($data);

        return redirect()->route('admin.seo.clusters.index')->with('success', 'تم التحديث بنجاح.');
    }

    public function destroy(SeoKeywordCluster $cluster): RedirectResponse
    {
        $cluster->delete();
        return redirect()->route('admin.seo.clusters.index')->with('success', 'تم الحذف بنجاح.');
    }

    public function importKeywords(Request $request, SeoKeywordCluster $cluster): RedirectResponse
    {
        $request->validate(['keywords_text' => 'required|string']);

        $keywords = array_filter(
            array_map('trim', explode("\n", $request->keywords_text))
        );

        foreach ($keywords as $keyword) {
            $cluster->keywords()->create(['keyword' => $keyword]);
        }

        return redirect()->back()->with('success', 'تم استيراد ' . count($keywords) . ' كلمات مفتاحية.');
    }
}
