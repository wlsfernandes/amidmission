<?php

namespace App\Http\Controllers;

use App\Helpers\S3;
use App\Models\Page;
use App\Models\Section;
use App\Models\SectionCard;
use Illuminate\Http\Request;

class SectionCardController extends Controller
{
    protected function validatedData(Request $request): array
    {
        return $request->validate([
            'title_en' => ['nullable', 'string', 'max:255'],
            'title_es' => ['nullable', 'string', 'max:255'],
            'content_en' => ['nullable', 'string'],
            'content_es' => ['nullable', 'string'],
            'link' => ['nullable', 'url'],
            'sort_order' => ['nullable', 'integer'],
        ]);
    }

    /**
     * List cards
     */
    public function index(Page $page, Section $section)
    {
        $cards = $section->cards()->orderBy('sort_order')->get();

        return view('admin.pages.sections.cards.index', compact(
            'page',
            'section',
            'cards'
        ));
    }

    /**
     * Create form
     */
    public function create(Page $page, Section $section)
    {
        return view('admin.pages.sections.cards.form', compact(
            'page',
            'section'
        ));
    }

    /**
     * Store card
     */
    public function store(Request $request, Page $page, Section $section)
    {
        $data = $this->validatedData($request);

        $data['section_id'] = $section->id;
        if ($request->hasFile('image_url')) {
            $data['image_url'] = S3::uploadImageAsWebpPreset(
                $request->file('image_url'),
                'pages/sections/cards'
            );
        }
        SectionCard::create($data);

        return redirect()
            ->route('pages.sections.cards.index', [$page, $section])
            ->with('success', 'Card created successfully.');
    }

    /**
     * Edit form
     */
    public function edit(Page $page, Section $section, SectionCard $card)
    {
        return view('admin.pages.sections.cards.form', [
            'sessionCard' => $card,
            'page' => $page,
            'section' => $section,
        ]);
    }

    /**
     * Update card
     */
    public function update(Request $request, Page $page, Section $section, SectionCard $card)
    {
        $data = $this->validatedData($request);
        if ($request->hasFile('image_url')) {
            $data['image_url'] = S3::uploadImageAsWebpPreset(
                $request->file('image_url'),
                'pages/sections/cards'
            );
        }
        $card->update($data);

        return redirect()
            ->route('pages.sections.cards.index', [$page, $section])
            ->with('success', 'Card updated successfully.');
    }

    /**
     * Delete card
     */
    public function destroy(Page $page, Section $section, SectionCard $card)
    {
        $card->delete();

        return redirect()
            ->route('pages.sections.cards.index', [$page, $section])
            ->with('success', 'Card deleted successfully.');
    }
}
