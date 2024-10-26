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

    //dd($request);

    //Assert (Verificar)
    $request->assertRedirect(route('dashboard'));
    assertDatabaseCount('questions', 1);
    assertDatabaseHas('questions', ['question' => str_repeat('*', 260) . '?']);
});

it('shoud check if ends with question mark', function () {
    //
});

it('should have at least 10 characters', function () {
    //
});
