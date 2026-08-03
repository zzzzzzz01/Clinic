<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use Illuminate\Http\Request;
use App\Services\FaqService;

class FaqController extends Controller
{
    protected $faqService;

    public function __construct(FaqService $faqService)
    {
        $this->faqService = $faqService;
    }

    public function index()
    {
        $faqs = $this->faqService->getAll();
        return view('dashboard.faqs.index', compact('faqs'));
    }

    public function create()
    {
        $nextSortOrder = Faq::max('sort_order') + 1;
        return view('dashboard.faqs.create', compact('nextSortOrder'));
    }

    public function store(Request $request)
    {
        // dd($request);
        try {
            $request->validate([
                'question_uz' => 'required|string|max:255',
                'question_ru' => 'required|string|max:255',
                'question_en' => 'required|string|max:255',
                'answer_uz' => 'required|string',
                'answer_ru' => 'required|string',
                'answer_en' => 'required|string',
                'sort_order' => 'nullable|integer|min:1',
                'status' => 'nullable|boolean',
            ]);

            Faq::create([
                'question_uz' => $request->question_uz,
                'question_ru' => $request->question_ru,
                'question_en' => $request->question_en,
                'answer_uz' => $request->answer_uz,
                'answer_ru' => $request->answer_ru,
                'answer_en' => $request->answer_en,
                'sort_order' => $request->sort_order ?? Faq::max('sort_order') + 1,
                'status' => $request->has('status') ? 1 : 0,
            ]);

            return redirect()->route('faqs.index')->with('success', 'Savol qo\'shildi!');
        } catch (\Exception $e) {
            return back()->with('error', 'Xatolik: ' . $e->getMessage());
        }
    }

    public function edit($faq)
    {
        $faq = $this->faqService->getById($faq);
        return view('dashboard.faqs.edit', compact('faq'));
    }

    public function update(Request $request, Faq $faq)
    {
        // dd($request);
        try {
            $request->validate([
                'question_uz' => 'nullable|string|max:255',
                'question_ru' => 'nullable|string|max:255',
                'question_en' => 'nullable|string|max:255',
                'answer_uz' => 'nullable|string',
                'answer_ru' => 'nullable|string',
                'answer_en' => 'nullable|string',
                'sort_order' => 'nullable|integer|min:1',
                'status' => 'nullable|boolean',
            ]);

            $faq->update([
                'question_uz' => $request->question_uz,
                'question_ru' => $request->question_ru,
                'question_en' => $request->question_en,
                'answer_uz' => $request->answer_uz,
                'answer_ru' => $request->answer_ru,
                'answer_en' => $request->answer_en,
                'sort_order' => $request->sort_order ?? $faq->sort_order,
                'status' => $request->status,
            ]);

            return redirect()->route('faqs.index')->with('success', 'Savol yangilandi!');
        } catch (\Exception $e) {
            return back()->with('error', 'Xatolik: ' . $e->getMessage());
        }
    }

    public function destroy(Faq $faq)
    {
        try {
            $faq->delete();

            return redirect()->route('faqs.index')->with('success', 'Savol o\'chirildi!');
        } catch (\Exception $e) {
            return back()->with('error', 'Xatolik: ' . $e->getMessage());
        }
    }
}
