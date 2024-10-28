<?php

use App\Models\{Question, User};

use function Pest\Laravel\put;

it('should be able to publish a question', function () {

    //Arrange
    $user = User::factory()->create();
    $this->actingAs($user);
    $question = Question::factory(['draft' => true])->create();

    //Act (Agir)
    put(route('question.publish', $question))->assertRedirect();

    //Assert
    expect($question->fresh())->draft->toBeFalse();
});
