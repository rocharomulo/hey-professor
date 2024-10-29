<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        $questions = Question::with('votes')->where('draft', false)->paginate(10);

        return view('dashboard', compact('questions'));
    }
}
