<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\Request;

class PagePublicController extends Controller
{
    public function show(Request $request)
    {
        $slug = trim($request->path(), '/');

        $page = Page::visible()
            ->where('slug', $slug)
            ->with([
                'banners' => fn ($q) => $q->published()->orderBy('sort_order'),
                'sections' => fn ($q) => $q->published(),
            ])
            ->firstOrFail();

        return view('frontend.pages.show', compact('page'));
    }
}
