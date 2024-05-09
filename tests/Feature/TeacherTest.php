<?php

use App\Models\Course;
use App\Models\User;
use Illuminate\Http\Response;
use Laravel\Sanctum\Sanctum;

beforeEach(function (): void {
    $this->teacher = User::factory()->create();
    $this->class = Course::factory()->create();
});

test('Teacher can see their classes', function () {
    $classes = Course::factory(5)->create();
    Course::factory(5)->create();
    $this->teacher->classes()->attach($classes);
    Sanctum::actingAs($this->teacher);

    $this->get(route('classes.index'))
        ->assertJsonCount(5, 'data')
        ->assertOk();
});

test('Teacher can see their classDetails', function () {
    $this->teacher->classes()->attach($this->class);
    Sanctum::actingAs($this->teacher);
    $this->getJson(route('classes.show', $this->class->id))->assertOk();
});

test('Teacher can not see un assigned class details', function () {
    $class = Course::factory()->create();
    Sanctum::actingAs($this->teacher);
    $this->getJson(route('classes.show', $class->id))
        ->assertStatus(Response::HTTP_UNAUTHORIZED);
});
