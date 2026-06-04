<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{

    public function index()
    {
        $articles = Article::latest('updated_at')->get();
        return view('admin.articles.index', compact('articles'));
    }

    public function create()
    {
        return view('admin.articles.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'          => ['required','string','max:255'],
            'page_slug'      => ['required','string','max:255'],
            'content'        => ['nullable','string'],
            'image_url'      => ['nullable','url'],                 // <–
            'image_position' => ['required','in:none,right,below'], // <–
        ]);
        $data['image_url'] = trim($data['image_url'] ?? '');
        $data['image_position'] = in_array(strtolower(trim($data['image_position'] ?? 'none')), ['none','right','below'])
            ? strtolower(trim($data['image_position']))
            : 'none';



        Article::create($data);

        return redirect()
            ->route('admin.articles.index')
            ->with('status', 'Článok bol vytvorený.');
    }

    public function edit(Article $article)
    {
        return view('admin.articles.edit', compact('article'));
    }

    public function update(Request $request, Article $article)
    {
        $data = $request->validate([
            'title'          => ['required','string','max:255'],
            'page_slug'      => ['required','string','max:255'],
            'content'        => ['nullable','string'],
            'image_url'      => ['nullable','url'],
            'image_position' => ['required','in:none,right,below'],
        ]);
        $data['image_url'] = trim($data['image_url'] ?? '');
        $data['image_position'] = in_array(strtolower(trim($data['image_position'] ?? 'none')), ['none','right','below'])
            ? strtolower(trim($data['image_position']))
            : 'none';



        $article->update($data);

        return redirect()
            ->route('admin.articles.index')
            ->with('status', 'Článok bol upravený.');
    }

    public function destroy(Article $article)
    {
        $article->delete();

        return redirect()
            ->route('admin.articles.index')
            ->with('status', 'Článok bol zmazaný.');
    }
}
