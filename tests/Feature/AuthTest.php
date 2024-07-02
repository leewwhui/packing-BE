<?php

use App\Models\User;

test('test login with validate user', function () {
    $response = $this->post('/api/login', ["email" => "test@example.com", "password" => "971213"], ["Accept" => "application/json"]);
    $response->assertStatus(200);
});

test('test login with invalidate user', function () {
    $response = $this->post('/api/login', ["email" => fake()->email, "password" => fake()->password], ["Accept" => "application/json"]);
    $response->assertStatus(401);
});

test("test register with validate user", function () {
    $password = fake()->password;
    $response = $this->post('/api/register', [
        "name" => fake()->name,
        "email" => fake()->email,
        "password" => $password,
        "password_confirmation" => $password],
        ["Accept" => "application/json"]);

    $response->assertStatus(200);
});

test("test register with different passwords", function () {
    $password = fake()->password;

    $response = $this->post('/api/register', [
        "name" => fake()->name,
        "email" => fake()->email,
        "password" => $password,
        "password_confirmation" => "helloworld123"],
        ["Accept" => "application/json"]);

    $response->assertStatus(422);
});

test("test register with exist user", function () {

    $response = $this->post('/api/register', [
        "name" => "Test",
        "email" => "test@example.com",
        "password" => "",
        "password_confirmation" => ""],
        ["Accept" => "application/json"]);

    $response->assertStatus(422);
});
