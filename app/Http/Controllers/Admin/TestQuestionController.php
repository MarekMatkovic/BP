<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Test;
use App\Models\TestQuestion;
use App\Models\TestOption;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TestQuestionController extends Controller
{

    public function edit(Test $test)
    {
        $test->load(['questions.options']);
        return view('admin.tests.questions', compact('test'));
    }

    public function update(Request $request, Test $test)
    {
        DB::transaction(function () use ($request, $test) {

            if ($qid = $request->input('delete_question')) {
                TestQuestion::where('test_id', $test->id)->where('id', $qid)->delete();
            }

            if ($oid = $request->input('delete_option')) {
                TestOption::whereHas('question', function ($q) use ($test) {
                    $q->where('test_id', $test->id);
                })->where('id', $oid)->delete();
            }

            foreach ((array)$request->input('questions', []) as $qid => $qdata) {
                $q = TestQuestion::where('test_id', $test->id)->find($qid);
                if ($q) {
                    $q->update([
                        'question' => $qdata['question'] ?? '',
                        'points'   => (int)($qdata['points'] ?? 1),
                    ]);
                }
            }

            foreach ((array)$request->input('options', []) as $oid => $odata) {
                $opt = TestOption::find($oid);
                if ($opt && $opt->question && $opt->question->test_id === $test->id) {
                    $opt->update(['text' => $odata['text'] ?? '']);
                }
            }

            foreach ((array)$request->input('correct', []) as $qid => $oid) {
                TestOption::whereHas('question', function ($q) use ($qid, $test) {
                    $q->where('id', $qid)->where('test_id', $test->id);
                })->update(['is_correct' => false]);

                TestOption::where('id', $oid)->update(['is_correct' => true]);
            }

            if ($qid = $request->input('add_option')) {
                $q = TestQuestion::where('test_id', $test->id)->find($qid);
                if ($q) {
                    TestOption::create([
                        'question_id' => $q->id,
                        'text'        => 'Nová možnosť',
                        'is_correct'  => false,
                    ]);
                }
            }

            if ($new = $request->input('new_question')) {
                $text   = trim($new['text'] ?? '');
                $points = (int)($new['points'] ?? 1);
                if ($text !== '') {
                    TestQuestion::create([
                        'test_id'  => $test->id,
                        'question' => $text,
                        'points'   => max(0, $points),
                    ]);
                }
            }

            $sum = TestQuestion::where('test_id', $test->id)->sum('points');
            $test->update(['max_points' => max(1, (int)$sum)]);
        });

        return back()->with('status', 'Zmeny boli uložené.');
    }
}
