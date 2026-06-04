<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Hash;
use App\Models\TestResult;

class ProfileController extends Controller
{
    public function show()
    {
        $user = Auth::user();

        $bestResults = \App\Models\TestResult::query()
            ->with('test:id,title,max_points')
            ->where('user_id', $user->id)
            ->select('test_id')
            ->selectRaw('MAX(points) as best_points')
            ->selectRaw('MAX(completed_at) as last_completed_at')
            ->groupBy('test_id')
            ->orderByDesc('best_points')
            ->get();

        return view('profile.show', [
            'user' => $user,
            'results' => $bestResults, // v šablóne použijeme toto
        ]);
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        $user = $request->user();
        $user->forceFill([
            'password' => Hash::make($request->password),
        ])->save();

        return back()->with('status', 'Heslo bolo zmenené.');
    }
}
