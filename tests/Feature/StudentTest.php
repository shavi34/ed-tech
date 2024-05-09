<?php

use App\Enum\UserRole;
use App\Models\Activity;
use App\Models\Course;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Response;
use Laravel\Sanctum\Sanctum;

beforeEach(function (): void {
    $this->student = Student::factory()->create();
});

test('Student data can be retrieved', function () {
    Sanctum::actingAs($this->student->user);
    $response = $this->get(route('auth.show'));
    $response->assertJsonFragment([
        'id' => $this->student->user->id,
        'student_id' => $this->student->id,
        'role_id' => UserRole::STUDENT,
    ])->assertOk();
});

test('Student can login with correct password', function () {
    $user = User::factory([
        'role_id' => UserRole::STUDENT,
    ])->create();

    $this->postJson(route('auth.login'), [
        'email' => $user->email,
        'password' => 'password',
    ])->assertJson(['message' => 'User Login successfully'])->assertOk();

});

test('Student can access their personal data', function () {
    Sanctum::actingAs($this->student->user);
    $this->getJson(route('students.show', $this->student->id))
        ->assertJson(['message' => 'Student details'])->assertOk();
});

test('Student can not access class endpoints', function () {
    $class = Course::factory()->create();
    Sanctum::actingAs($this->student->user);
    $this->getJson(route('classes.index', $this->student->id))
        ->assertStatus(Response::HTTP_UNAUTHORIZED);

    $this->getJson(route('classes.show', $class->id))
        ->assertStatus(Response::HTTP_UNAUTHORIZED);

    $this->getJson(route('class.students', $class->id))
        ->assertStatus(Response::HTTP_UNAUTHORIZED);
});

test('Student can see their activities', function () {
    Activity::factory(['student_id' => $this->student->id])->create();
    Sanctum::actingAs($this->student->user);
    $this->getJson(route('students.show', $this->student->id))
        ->assertOk();

});

test('Student can not access other student details', function () {
    $student1 = Student::factory()->create();
    Sanctum::actingAs($this->student->user);
    $this->getJson(route('students.show', $student1->id))
        ->assertStatus(Response::HTTP_UNAUTHORIZED);
});
