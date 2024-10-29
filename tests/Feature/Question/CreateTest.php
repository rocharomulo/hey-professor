<?php

use App\Models\User;

use function Pest\Laravel\{assertDatabaseCount, assertDatabaseHas};

it('shoud be able to create a question bigger than 255 chars', function () {

    //Arrange (preparar),
    $user = User::factory()->create();
    $this->actingAs($user);

    //Act (Agir)
    $request = $this->withoutMiddleware()->post(route('question.store'), [
        'question' => str_repeat('*', 260) . '?',
    ]);

    $response = $this->post(route('question.store'), [
        'question' => str_repeat('*', 260) . '?',
    ])->assertRedirect();

    //Assert (Verificar)
    assertDatabaseCount('questions', 2);
    assertDatabaseHas('questions', ['question' => str_repeat('*', 260) . '?']);
});

it('shoud check if ends with question mark', function () {
    //Arrange (preparar),
    $user = User::factory()->create();
    $this->actingAs($user);

    //Act (Agir)
    $request = $this->withoutMiddleware()->post(route('question.store'), [
        'question' => str_repeat('*', 10),
    ]);

    //Assert (Verificar)
    $request->assertSessionHasErrors(['question' => "Are you sure that it is a question? It is missing the question mark in the end."]);
});

it('should have at least 10 characters', function () {
    //Arrange (preparar),
    $user = User::factory()->create();
    $this->actingAs($user);

    //Act (Agir)
    $request = $this->withoutMiddleware()->post(route('question.store'), [
        'question' => str_repeat('*', 8) . '?',
    ]);

    //Assert (Verificar)
    $request->assertSessionHasErrors(['question']);
    assertDatabaseCount('questions', 0);
});

it('shoud create as draft all the time', function () {
    //Arrange (preparar),
    $user = User::factory()->create();
    $this->actingAs($user);

    //Act (Agir)
    $this->post(route('question.store'), [
        'question' => str_repeat('*', 260) . '?',
    ]);

    //Assert (Verificar)
    assertDatabaseHas('questions', [
        'question' => str_repeat('*', 260) . '?',
        'draft'    => true,
    ]);
});

test('only authenticated users can create new question', function () {

    $this->post(route('question.store'), [
        'question' => str_repeat('*', 260) . '?',
    ])->assertRedirect(route('login'));
});
