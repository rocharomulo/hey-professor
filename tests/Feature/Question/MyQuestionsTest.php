<?php

use App\Models\{Question, User};

use function Pest\Laravel\{actingAs, get};

it('should be able to list all questions created by me', function () {

    $wrongUser      = User::factory()->create();
    $wrongQuestions = Question::factory()->for($wrongUser, 'createdBy')->count(10)->create();

    $rightUser = User::factory()->create();
    $questions = Question::factory()->for($rightUser, 'createdBy')->count(10)->create();

    actingAs($rightUser);

    $response = get(route('question.index'));

    foreach ($questions as $q) {
        $response->assertSee($q->question);
    }

    foreach ($wrongQuestions as $q) {
        $response->assertDontSee($q->question);
    }
});
