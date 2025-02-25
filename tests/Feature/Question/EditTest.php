<?php

use App\Models\{Question, User};

use function Pest\Laravel\{get};

it('should be able to open a question to edit', function () {
    //Arrange (preparar),
    $user = User::factory()->create();
    $this->actingAs($user);

    $question = Question::factory()->for($user, 'createdBy')->create(['draft' => true]);

    get(route('question.edit', $question))->assertSuccessful();
});

it('shoud return a view', function () {
    //Arrange (preparar),
    $user = User::factory()->create();
    $this->actingAs($user);

    $question = Question::factory()->for($user, 'createdBy')->create(['draft' => true]);

    get(route('question.edit', $question))->assertViewIs('question.edit');
});

test('make sure that only question with DRAFT status can be edited', function () {
    //Arrange (preparar),
    $user = User::factory()->create();
    $this->actingAs($user);

    $questionDraft    = Question::factory()->for($user, 'createdBy')->create(['draft' => true]);
    $questionNotDraft = Question::factory()->for($user, 'createdBy')->create(['draft' => false]);

    get(route('question.edit', $questionNotDraft))->assertForbidden();
    get(route('question.edit', $questionDraft))->assertSuccessful();
});

it('should make sure that only the person who has created the question can edit', function () {
    //Arrange
    $rightUser = User::factory()->create();
    $wrongUser = User::factory()->create();

    $question = Question::factory()->for($rightUser, 'createdBy')->create(['draft' => true]);

    //Act (Agir)
    $this->actingAs($wrongUser);
    get(route('question.edit', $question))->assertForbidden();

    $this->actingAs($rightUser);
    get(route('question.edit', $question))->assertSuccessful();
});
