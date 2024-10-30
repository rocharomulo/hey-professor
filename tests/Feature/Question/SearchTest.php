<?php

use App\Models\{Question, User};

use function Pest\Laravel\get;

it('should be able to search a question by text', function () {
    //Arrange
    $user = User::factory()->create();
    $this->actingAs($user);
    $wrongQuestions = Question::factory()->count(5)->create(['question' => 'Something else?', 'draft' => false]);
    $question       = Question::factory()->create(['question' => 'My question?', 'draft' => false]);

    //Act
    $response = get(route('dashboard', ['search' => 'question']));

    //Assert
    foreach ($wrongQuestions as $q) {
        $response->assertDontSee($q->question);
    }

    //$response->assertSee($question->question);
});
