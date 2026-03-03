<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SeoTemplate;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SeoTemplateController extends Controller
{
    public function index(): View
    {
        $templates = SeoTemplate::orderBy('template_key')->paginate(20);
        return view('admin.seo.templates.index', compact('templates'));
    }

    public function create(): View
    {
        return view('admin.seo.templates.form', ['template' => new SeoTemplate()]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'template_key' => 'required|string|max:100|unique:seo_templates,template_key',
            'language'     => 'required|string|in:ar,en',
            'body'         => 'required|string',
        ]);

        SeoTemplate::create($data);

        return redirect()->route('admin.seo.templates.index')->with('success', 'تم إنشاء القالب بنجاح.');
    }

    public function edit(SeoTemplate $template): View
    {
        return view('admin.seo.templates.form', compact('template'));
    }

    public function update(Request $request, SeoTemplate $template): RedirectResponse
    {
        $data = $request->validate([
            'template_key' => 'required|string|max:100|unique:seo_templates,template_key,' . $template->id,
            'language'     => 'required|string|in:ar,en',
            'body'         => 'required|string',
        ]);

        $template->update($data);

        return redirect()->route('admin.seo.templates.index')->with('success', 'تم التحديث بنجاح.');
    }

    public function destroy(SeoTemplate $template): RedirectResponse
    {
        $template->delete();
        return redirect()->route('admin.seo.templates.index')->with('success', 'تم الحذف بنجاح.');
    }
}
