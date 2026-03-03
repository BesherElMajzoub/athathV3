<?php

namespace App\Http\Controllers;

use App\Models\ProgrammaticPage;
use App\Services\Seo\SchemaBuilder;
use Illuminate\View\View;

class ProgrammaticPagePublicController extends Controller
{
    public function __construct(private SchemaBuilder $schemaBuilder) {}

    public function show(string $slug): View
    {
        $page = ProgrammaticPage::where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();

        $schema = $this->schemaBuilder->forProgrammaticPage($page);
        $breadcrumbSchema = $this->schemaBuilder->breadcrumb([
            ['name' => 'الرئيسية', 'url' => url('/')],
            ['name' => $page->title, 'url' => url('/p/' . $page->slug)],
        ]);

        return view('programmatic.show', compact('page', 'schema', 'breadcrumbSchema'));
    }
}
