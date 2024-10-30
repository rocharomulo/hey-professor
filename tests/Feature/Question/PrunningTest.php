<?php

use App\Models\{Question, User};

use function Pest\Laravel\{artisan, assertDatabaseMissing};

it('shoud prune records deleted more than 1 month', function () {
    //Arrange
    $user = User::factory()->create();
    $this->actingAs($user);
    $question = Question::factory(['created_by' => $user->id])->create(['deleted_at' => now()->subMonth(2)]);

    artisan('model:prune');

    assertDatabaseMissing('questions', ['id' => $question->id]);
});
