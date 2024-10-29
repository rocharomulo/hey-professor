<?php

use App\Models\{Question, User};

use function Pest\Laravel\{actingAs, put};

it('shoud be able to update a question', function () {

    //Arrange (preparar),
    $user = User::factory()->create();
    $this->actingAs($user);

    $question = Question::factory()->for($user, 'createdBy')->create(['draft' => true]);

    actingAs($user);

    put(route('question.update', $question), ['question' => 'updated question?'])->assertRedirect();

    $question->refresh();

    expect($question->question)->toBe('updated question?');
});
