<?php

namespace App\Http\Controllers;

use App\Models\Test;
use App\Models\TestResult;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TestController extends Controller
{
    public function show(Test $test)
    {
        $test->load(['questions.options']);
        return view('tests.show', compact('test'));
    }

    public function submit(Request $request, Test $test)
    {
        $test->load(['questions.options']);

        $answers = $request->input('answers', []);
        $points = 0;

        foreach ($test->questions as $q) {
            $chosen = (int)($answers[$q->id] ?? 0);
            $correct = $q->options->firstWhere('is_correct', true);
            if ($correct && $chosen === $correct->id) {
                $points += $q->points;
            }
        }

        if (Auth::check()) {
            TestResult::create([
                'user_id' => Auth::id(),
                'test_id' => $test->id,
                'points'  => $points,
                'completed_at' => now(),
            ]);
        }

        return redirect()
            ->route('hub.section', ['slug' => $test->page_slug ?: 'Slovencina1'])
            ->with('status', "Test odovzdaný. Získal si $points / {$test->max_points} bodov (".
                ($test->max_points ? round($points/$test->max_points*100,2) : 0) ."%).");
    }
}

