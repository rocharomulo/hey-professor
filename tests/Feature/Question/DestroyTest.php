<?php

use App\Models\{Question, User};

use function Pest\Laravel\{assertDatabaseMissing, delete};

it('should be able to destroy a question', function () {

    //Arrange
    $user = User::factory()->create();
    $this->actingAs($user);
    $question = Question::factory(['created_by' => $user->id])->create();

    //Act (Agir)
    delete(route('question.destroy', $question))->assertRedirect();

    //Assert
    assertDatabaseMissing('questions', ['id' => $question->id]);
});

it('should make sure that only the person who has created the question can destroy', function () {
    //Arrange
    $rightUser = User::factory()->create();
    $wrongUser = User::factory()->create();

    $this->actingAs($wrongUser);
    $question = Question::factory(['created_by' => $rightUser->id])->create();

    //Act (Agir)
    delete(route('question.destroy', $question))->assertForbidden();

    $this->actingAs($rightUser);
    delete(route('question.destroy', $question))->assertRedirect();
});
