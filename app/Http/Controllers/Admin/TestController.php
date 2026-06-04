<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Test;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function index()
    {
        $tests = Test::latest('updated_at')->get();
        return view('admin.tests.index', compact('tests'));
    }

    public function create()
    {
        return view('admin.tests.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'       => ['required', 'string', 'max:255'],
            'page_slug'   => ['required', 'string', 'max:255'],
            'max_points'  => ['required', 'integer', 'min:1'],
        ]);

        Test::create($data);

        return redirect()
            ->route('admin.tests.index')
            ->with('status', 'Test bol vytvorený.');
    }

    public function edit(Test $test)
    {
        return view('admin.tests.edit', compact('test'));
    }

    public function update(Request $request, Test $test)
    {
        $data = $request->validate([
            'title'       => ['required', 'string', 'max:255'],
            'page_slug'   => ['required', 'string', 'max:255'],
            'max_points'  => ['required', 'integer', 'min:1'],
        ]);

        $test->update($data);

        return redirect()
            ->route('admin.tests.index')
            ->with('status', 'Test bol upravený.');
    }

    public function destroy(Test $test)
    {
        $test->delete();

        return redirect()
            ->route('admin.tests.index')
            ->with('status', 'Test bol zmazaný.');
    }
}
