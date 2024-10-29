<?php

use App\Models\{Question, User};
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

use function Pest\Laravel\get;

it('should list all the questions except draft', function () {
    //Arrange
    $user = User::factory()->create();
    $this->actingAs($user);
    $questions = Question::factory()->count(5)->create(['draft' => false]);

    //Act
    $response = get(route('dashboard'));

    //Assert
    foreach ($questions as $q) {
        $response->assertSee($q->question);
    }

    $questions = Question::factory()->count(5)->create(['draft' => true]);

    //Act
    $response = get(route('dashboard'));

    //Assert
    foreach ($questions as $q) {
        $response->assertDontSee($q->question);
    }
});

it('should paginate the results', function () {
    //Arrange
    $user = User::factory()->create();
    $this->actingAs($user);
    $questions = Question::factory()->count(50)->create(['draft' => false]);

    //Act
    $response = get(route('dashboard'))->assertViewHas('questions', function ($value) {
        return $value instanceof LengthAwarePaginator;
    });
});
