<?php

use App\Models\{Question, User};

use function Pest\Laravel\{actingAs, assertDatabaseCount, assertDatabaseHas, put};

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

test('make sure that only question with DRAFT status can be updated', function () {
    //Arrange (preparar),
    $user = User::factory()->create();
    $this->actingAs($user);

    $questionDraft    = Question::factory()->for($user, 'createdBy')->create(['draft' => true]);
    $questionNotDraft = Question::factory()->for($user, 'createdBy')->create(['draft' => false]);

    put(route('question.update', $questionNotDraft))->assertForbidden();
    put(route('question.update', $questionDraft), ['question' => 'updated question?'])->assertRedirect();
});

it('should make sure that only the person who has created the question can update', function () {
    //Arrange
    $rightUser = User::factory()->create();
    $wrongUser = User::factory()->create();

    $question = Question::factory()->for($rightUser, 'createdBy')->create(['draft' => true]);

    //Act (Agir)
    $this->actingAs($wrongUser);
    put(route('question.update', $question))->assertForbidden();

    $this->actingAs($rightUser);
    put(route('question.update', $question))->assertRedirect();
});

it('shoud be able to update a question bigger than 255 chars', function () {

    //Arrange (preparar),
    $user = User::factory()->create();
    $this->actingAs($user);

    $question = Question::factory()->for($user, 'createdBy')->create(['draft' => true]);

    //Act (Agir)
    $response = $this->put(route('question.update', $question), [
        'question' => str_repeat('*', 260) . '?',
    ])->assertRedirect();

    //Assert (Verificar)
    assertDatabaseCount('questions', 1);
    assertDatabaseHas('questions', ['question' => str_repeat('*', 260) . '?']);
});

it('shoud check if ends with question mark', function () {
    //Arrange (preparar),
    $user = User::factory()->create();
    $this->actingAs($user);

    $question = Question::factory()->for($user, 'createdBy')->create(['draft' => true]);

    //Act (Agir)
    $request = $this->put(route('question.update', $question), [
        'question' => str_repeat('*', 10),
    ]);

    //Assert (Verificar)
    $request->assertSessionHasErrors(['question' => "Are you sure that it is a question? It is missing the question mark in the end."]);

    assertDatabaseHas('questions', ['question' => $question->question]);
    assertDatabaseCount('questions', 1);
});

it('should have at least 10 characters', function () {
    //Arrange (preparar),
    $user = User::factory()->create();
    $this->actingAs($user);

    $question = Question::factory()->for($user, 'createdBy')->create(['draft' => true]);

    //Act (Agir)
    $request = $this->put(route('question.update', $question), [
        'question' => str_repeat('*', 8) . '?',
    ]);

    //Assert (Verificar)
    $request->assertSessionHasErrors(['question']);
});
