<?php

use App\Models\{Question, User};

use function Pest\Laravel\{actingAs, assertSoftDeleted, patch};

it('shoud be able to archive a question', function () {

    //Arrange
    $user = User::factory()->create();
    actingAs($user);
    $question = Question::factory(['created_by' => $user->id])->create();

    //Act (Agir)
    patch(route('question.archive', $question))->assertRedirect();

    //Assert
    assertSoftDeleted('questions', ['id' => $question->id]);
});

it('should make sure that only the person who has created the question can archive', function () {
    //Arrange
    $rightUser = User::factory()->create();
    $wrongUser = User::factory()->create();

    $this->actingAs($wrongUser);
    $question = Question::factory(['created_by' => $rightUser->id])->create();

    //Act (Agir)
    patch(route('question.archive', $question))->assertForbidden();

    $this->actingAs($rightUser);
    patch(route('question.archive', $question))->assertRedirect();
});
