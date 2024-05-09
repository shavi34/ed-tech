<?php

use App\Models\User;
use Illuminate\Http\Response;
use Laravel\Sanctum\Sanctum;

test('User data can be retrieved', function () {
    Sanctum::actingAs(
        User::factory()->create(),
        ['user-details']
    );
    $response = $this->get('/api/user');
    $response->assertOk();
});

test('User can login with correct password', function () {
    $user = User::factory()->create();

    $this->postJson(route('auth.login'), [
        'email' => $user->email,
        'password' => 'password',
    ])->assertJson(['message' => 'User Login successfully'])->assertOk();
});

test('User can register and login', function () {
    $user = User::factory()->raw();

    $this->postJson(route('auth.register'), [
        ...$user,
        'password' => 'password',
        'password_confirmation' => 'password',
    ])->assertJson(['message' => 'User created successfully'])->assertStatus(Response::HTTP_CREATED);

    $this->postJson(route('auth.login'), [
        'email' => $user['email'],
        'password' => 'password',
    ])->assertJson(['message' => 'User Login successfully'])->assertOk();

});

test('User can not login with incorrect password', function () {
    $user = User::factory()->create();

    $this->postJson(route('auth.login'), [
        'email' => $user->email,
        'password' => 'InValidPassword',
    ])->assertJson(['message' => 'Not Found'])
        ->assertStatus(Response::HTTP_UNAUTHORIZED);
});

test('User can login with incorrect email', function () {
    $response = $this->postJson(route('auth.login'), [
        'email' => 'invalid@email.com',
        'password' => 'password',
    ])->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
});
