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
    ]);

    //Assert (Verificar)
    $response->assertRedirect(route('dashboard'));
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
