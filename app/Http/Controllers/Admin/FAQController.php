<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\FAQ;
use Illuminate\Http\Request;

class FAQController extends Controller
{
    public function index(Request $request)
    {
        $query = FAQ::query();

        if ($request->filled('q')) {
            $search = $request->get('q');
            $query->where(function ($q) use ($search) {
                $q->where('question', 'like', "%{$search}%")
                  ->orWhere('answer', 'like', "%{$search}%");
            });
        }

        if ($request->filled('category')) {
            $query->where('category', $request->get('category'));
        }

        if ($request->filled('status')) {
            $query->where('is_active', $request->get('status') === 'active');
        }

        $faqs = $query->orderBy('sort_order', 'asc')->orderBy('id', 'desc')->paginate(10)->withQueryString();
        $categories = FAQ::select('category')->distinct()->pluck('category')->filter()->values();

        return view('admin.faqs.index', compact('faqs', 'categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'question' => 'required|string|max:255',
            'answer' => 'required|string',
            'category' => 'nullable|string|max:50',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'sometimes|boolean',
        ]);

        $faq = FAQ::create([
            'question' => $validated['question'],
            'answer' => $validated['answer'],
            'category' => $validated['category'] ?: 'general',
            'sort_order' => $validated['sort_order'] ?? 0,
            'is_active' => $request->has('is_active'),
        ]);

        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'ADMIN_CREATE_FAQ',
            'description' => "Admin menambahkan FAQ baru: \"{$faq->question}\"",
            'new_values' => $faq->toArray(),
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return redirect()->route('admin.faqs.index')->with('success', 'FAQ baru berhasil ditambahkan!');
    }

    public function update(Request $request, FAQ $faq)
    {
        $validated = $request->validate([
            'question' => 'required|string|max:255',
            'answer' => 'required|string',
            'category' => 'nullable|string|max:50',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'sometimes|boolean',
        ]);

        $oldValues = $faq->toArray();

        $faq->update([
            'question' => $validated['question'],
            'answer' => $validated['answer'],
            'category' => $validated['category'] ?: 'general',
            'sort_order' => $validated['sort_order'] ?? 0,
            'is_active' => $request->has('is_active'),
        ]);

        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'ADMIN_UPDATE_FAQ',
            'description' => "Admin memperbarui FAQ #{$faq->id}: \"{$faq->question}\"",
            'old_values' => $oldValues,
            'new_values' => $faq->toArray(),
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return redirect()->route('admin.faqs.index')->with('success', 'FAQ berhasil diperbarui!');
    }

    public function toggleStatus(Request $request, FAQ $faq)
    {
        $oldStatus = $faq->is_active;
        $faq->is_active = !$faq->is_active;
        $faq->save();

        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'ADMIN_TOGGLE_FAQ_STATUS',
            'description' => "Status FAQ #{$faq->id} diubah menjadi " . ($faq->is_active ? 'AKTIF' : 'NONAKTIF'),
            'old_values' => ['is_active' => $oldStatus],
            'new_values' => ['is_active' => $faq->is_active],
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        $statusText = $faq->is_active ? 'diaktifkan' : 'dinonaktifkan';
        return redirect()->back()->with('success', "FAQ berhasil {$statusText}.");
    }

    public function destroy(Request $request, FAQ $faq)
    {
        $question = $faq->question;
        $oldValues = $faq->toArray();

        $faq->delete();

        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'ADMIN_DELETE_FAQ',
            'description' => "Admin menghapus FAQ: \"{$question}\"",
            'old_values' => $oldValues,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return redirect()->route('admin.faqs.index')->with('success', 'FAQ berhasil dihapus.');
    }
}
