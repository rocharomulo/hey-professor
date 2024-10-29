<?php

use App\Models\{Question, User};

use function Pest\Laravel\put;

it('should be able to publish a question', function () {

    //Arrange
    $user = User::factory()->create();
    $this->actingAs($user);
    $question = Question::factory(['draft' => true, 'created_by' => $user->id])->create();

    //Act (Agir)
    put(route('question.publish', $question))->assertRedirect();

    //Assert
    expect($question->fresh())->draft->toBeFalse();
});

it('should make sure that only the person who has created the question can publish', function () {
    //Arrange
    $rightUser = User::factory()->create();
    $wrongUser = User::factory()->create();

    $this->actingAs($wrongUser);
    $question = Question::factory(['draft' => true, 'created_by' => $rightUser->id])->create();

    //Act (Agir)
    put(route('question.publish', $question))->assertForbidden();

    $this->actingAs($rightUser);
    put(route('question.publish', $question))->assertRedirect();
});
