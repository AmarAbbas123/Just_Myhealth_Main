<?php

namespace App\Http\Controllers\Modules\Mod01SystemAdministration\FAQ;

use App\Http\Controllers\Controller;
use App\Models\FAQ;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class FAQController extends Controller
{
    // GET /mod-01/tm/faqs
    public function index()
    {
        $faqs = FAQ::orderBy('SortOrder')->orderBy('id')->paginate(20);

        return view('modules.mod-01.faqs.index', compact('faqs'));
    }

    // GET /mod-01/tm/faqs/create
    public function create()
    {
        return view('modules.mod-01.faqs.form', [
            'faq' => new FAQ(),
        ]);
    }

    // POST /mod-01/tm/faqs
    public function store(Request $request)
    {
        $validated = $this->validateFAQ($request);

        $faq = FAQ::create($validated);

        return redirect()
            ->route('faqs.index')
            ->with('status', 'FAQ created.');
    }

    // GET /mod-01/tm/faqs/{faq}/edit
    public function edit(FAQ $faq)
    {
        return view('modules.mod-01.faqs.form', [
            'faq' => $faq,
        ]);
    }

    // PUT/PATCH /mod-01/tm/faqs/{faq}
    public function update(Request $request, FAQ $faq)
    {
        $validated = $this->validateFAQ($request, $faq->id);

        $faq->fill($validated);
        $faq->save();

        return redirect()
            ->route('faqs.index')
            ->with('status', 'FAQ updated.');
    }

    // DELETE /mod-01/tm/faqs/{faq}
    public function destroy(FAQ $faq)
    {
        $faq->delete();

        return redirect()
            ->route('faqs.index')
            ->with('status', 'FAQ deleted.');
    }

    private function validateFAQ(Request $request, ?int $ignoreId = null): array
    {
        return $request->validate([
            'Question'  => ['required', 'string'],
            'Answer'    => ['required', 'string'],
            'SortOrder' => ['required', 'integer', 'min:0'],
            'Section'   => ['nullable', 'string', 'max:100'],
            'IsActive'  => ['sometimes', 'boolean'],
            'HashTag'   => [
                'nullable',
                'string',
                'max:100',
                'regex:/^[a-zA-Z0-9_-]+$/',
                Rule::unique('faqs', 'HashTag')->ignore($ignoreId),
            ],
        ]);
    }
}