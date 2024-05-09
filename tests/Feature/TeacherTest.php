<?php

use App\Models\Course;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Response;
use Laravel\Sanctum\Sanctum;

beforeEach(function (): void {
    $this->teacher = User::factory()->create();
    $this->class = Course::factory()->create();
    Sanctum::actingAs($this->teacher);
});

test('Teacher can see their classes', function () {
    $classes = Course::factory(5)->create();
    Course::factory(5)->create();
    $this->teacher->classes()->attach($classes);
    $this->getJson(route('classes.index'))
        ->assertJsonCount(5, 'data')
        ->assertOk();
});

test('Teacher can see their classDetails', function () {
    $this->teacher->classes()->attach($this->class);
    $this->getJson(route('classes.show', $this->class->id))->assertOk();
});

test('Teacher can not see unassigned class details', function () {
    $this->getJson(route('classes.show', $this->class->id))
        ->assertStatus(Response::HTTP_UNAUTHORIZED);
});

test('Teacher can see assigned student details', function () {
    $this->teacher->classes()->attach($this->class);
    $student = Student::factory(['course_id' => $this->class->id])->create();
    $this->getJson(route('students.show', $student->id))
        ->assertJson(['message' => 'Student details'])->assertOk();
});

test('Teacher can not see unassigned student details', function () {
    $this->class = Course::factory()->create();
    $student = Student::factory(['course_id' => $this->class->id])->create();

    $this->getJson(route('students.show', $student->id))
        ->assertStatus(Response::HTTP_UNAUTHORIZED);
});
