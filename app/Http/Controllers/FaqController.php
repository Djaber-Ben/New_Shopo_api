<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    public function index()
    {
        $faqs = Faq::latest()->get();
        return view('admin.siteInfos.faqs.index', compact('faqs'));
    }

    public function create()
    {
        return view('admin.siteInfos.faqs.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'questions.*' => 'required|string|max:500',
            'answers.*'   => 'required|string',
        ]);

        // Loop through each question and insert matching answer
        foreach ($request->questions as $index => $question) {
            Faq::create([
                'question' => $question,
                'answer'   => $request->answers[$index] ?? '',
            ]);
        }

    //     $faqs = collect($request->questions)->map(function ($question, $index) use ($request) {
    //     return [
    //         'question' => $question,
    //         'answer'   => $request->answers[$index] ?? '',
    //         'created_at' => now(),
    //         'updated_at' => now(),
    //     ];
    // })->toArray();

    // Faq::insert($faqs);

        return redirect()->route('faqs.index')->with('success', 'تم إنشاء الأسئلة الشائعة بنجاح.');
    }

    public function edit(Faq $faq)
    {
        return view('admin.siteInfos.faqs.edit', compact('faq'));
    }

    public function update(Request $request, Faq $faq)
    {
        $request->validate([
            'question' => 'required|string|max:500',
            'answer'   => 'required|string',
        ]);

        $faq->update($request->only('question', 'answer'));

        return redirect()->route('faqs.index')->with('success', 'تم تحديث الأسئلة الشائعة بنجاح.');
    }

    public function destroy(Faq $faq)
    {
        $faq->delete();

        return redirect()
            ->route('faqs.index')
            ->with('success', 'تم حذف الأسئلة الشائعة بنجاح.');
    }
}