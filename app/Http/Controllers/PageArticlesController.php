<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\PageSection;
use Illuminate\Support\Str;
use App\Models\Test;

class PageArticlesController extends Controller
{
    public function show(string $slug)
    {
        $section = PageSection::where('slug', $slug)->first();
        $sectionTitle = $section?->title ?? Str::headline($slug);
        $sectionTest = Test::where('page_slug', $slug)->first();

        $articles = \App\Models\Article::query()
            ->where('page_slug', $slug)

            ->select(['id','title','content','page_slug','image_url','image_position'])
            ->orderBy('id')
            ->get();


        return view('pages.by-slug', [
            'slug' => $slug,
            'sectionTitle' => $sectionTitle,
            'articles' => $articles,
            'sectionTest'  => $sectionTest,
        ]);
    }
}


