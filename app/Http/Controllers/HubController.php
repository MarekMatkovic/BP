<?php

namespace App\Http\Controllers;

use App\Models\PageSection;

class HubController extends Controller
{
    public function index()
    {
        $sections = PageSection::query()
            ->withCount('articles')
            ->orderBy('title')
            ->get(['id','slug','title']);

        return view('hub', compact('sections'));
    }
}
