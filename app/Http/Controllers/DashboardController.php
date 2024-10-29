<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        $questions = Question::withSum('votes', 'like')->withSum('votes', 'unlike')
            ->orderByRaw('
            case when votes_sum_like is null then 0 else votes_sum_like end desc,
            case when votes_sum_unlike is null then 0 else votes_sum_unlike end
            ')
            ->where('draft', false)->paginate(10);

        return view('dashboard', compact('questions'));
    }
}
