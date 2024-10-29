<?php

use App\Models\{Question, User};

use function Pest\Laravel\get;

it('should be able to open a question to edit', function () {
    //Arrange (preparar),
    $user = User::factory()->create();
    $this->actingAs($user);

    $question = Question::factory()->for($user, 'createdBy')->create();

    get(route('question.edit', $question))->assertSuccessful();
});

it('shoud return a view', function () {
    //Arrange (preparar),
    $user = User::factory()->create();
    $this->actingAs($user);

    $question = Question::factory()->for($user, 'createdBy')->create();

    get(route('question.edit', $question))->assertViewIs('question.edit');
});
