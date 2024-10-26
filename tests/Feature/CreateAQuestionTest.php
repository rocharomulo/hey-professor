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

    //Assert (Verificar)
    $request->assertRedirect(route('dashboard'));
    assertDatabaseCount('questions', 1);
    assertDatabaseHas('questions', ['question' => str_repeat('*', 260) . '?']);
});

it('shoud check if ends with question mark', function () {
    //Arrange (preparar),
    $user = User::factory()->create();
    $this->actingAs($user);

    //Act (Agir)
    $request = $this->withoutMiddleware()->post(route('question.store'), [
        'question' => str_repeat('*', 8) . '?',
    ]);

    //Assert (Verificar)
    $request->assertSectionHasErrors(['question']);
    assertDatabaseCount('questions', 0);
});

it('should have at least 10 characters', function () {
    //
});
