<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContentCalendarItem;
use App\Models\Post;
use App\Models\ProgrammaticPage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\View\View;

class ContentCalendarController extends Controller
{
    public function index(Request $request): View
    {
        $items = ContentCalendarItem::orderBy('scheduled_for')
            ->when($request->filled('status'), fn($q) => $q->where('status', $request->status))
            ->paginate(30)
            ->withQueryString();

        $posts = Post::draft()->select('id', 'title')->get();
        $programmaticPages = ProgrammaticPage::where('status', 'draft')->select('id', 'title')->get();

        return view('admin.calendar.index', compact('items', 'posts', 'programmaticPages'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'type'          => 'required|in:blog_post,programmatic_page',
            'entity_id'     => 'required|integer',
            'scheduled_for' => 'required|date|after:now',
            'notes'         => 'nullable|string',
        ]);

        ContentCalendarItem::create($data);

        return redirect()->route('admin.calendar.index')->with('success', 'تمت إضافة العنصر إلى التقويم.');
    }

    public function bulkSchedule(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'type'       => 'required|in:blog_post,programmatic_page',
            'entity_ids' => 'required|array',
            'start_date' => 'required|date|after:today',
            'interval'   => 'required|integer|min:1|max:7', // days between posts
        ]);

        $startDate = Carbon::parse($data['start_date']);

        foreach ($data['entity_ids'] as $i => $entityId) {
            $scheduledFor = $startDate->copy()->addDays($i * $data['interval']);

            ContentCalendarItem::create([
                'type'          => $data['type'],
                'entity_id'     => $entityId,
                'scheduled_for' => $scheduledFor,
                'status'        => 'pending',
            ]);
        }

        return redirect()->route('admin.calendar.index')
            ->with('success', 'تمت جدولة ' . count($data['entity_ids']) . ' عنصر بنجاح.');
    }

    public function publishNow(ContentCalendarItem $item): RedirectResponse
    {
        $entity = $item->getEntity();

        if (!$entity) {
            return redirect()->back()->with('error', 'العنصر غير موجود.');
        }

        if ($item->type === 'blog_post') {
            $entity->update(['status' => 'published', 'published_at' => now()]);
        } else {
            $entity->update(['status' => 'published']);
        }

        $item->update(['status' => 'published']);

        return redirect()->back()->with('success', 'تم النشر فوراً.');
    }

    public function skip(ContentCalendarItem $item): RedirectResponse
    {
        $item->update(['status' => 'skipped']);
        return redirect()->back()->with('success', 'تم تخطي العنصر.');
    }

    public function destroy(ContentCalendarItem $item): RedirectResponse
    {
        $item->delete();
        return redirect()->route('admin.calendar.index')->with('success', 'تم الحذف بنجاح.');
    }
}
