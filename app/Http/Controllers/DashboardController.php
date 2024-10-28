<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        $questions = Question::with('votes')->get();

        return view('dashboard', compact('questions'));
    }
}
