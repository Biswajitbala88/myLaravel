<?php

use App\Models\User;

beforeEach(function () {
    $this->user = User::factory()->create();
});

it('can list users', function () {
    $response = $this->actingAs($this->user)->get(route('users.index'));

    $response->assertStatus(200);
    $response->assertSee($this->user->name);
});

it('can show the create user page', function () {
    $response = $this->actingAs($this->user)->get(route('users.create'));

    $response->assertStatus(200);
});

it('can store a new user', function () {
    $userData = [
        'name' => 'New User',
        'email' => 'newuser@example.com',
        'password' => 'password123',
        'password_confirmation' => 'password123',
    ];

    $response = $this->actingAs($this->user)->post(route('users.store'), $userData);

    $response->assertRedirect(route('users.index'));
    $this->assertDatabaseHas('users', [
        'email' => 'newuser@example.com',
    ]);
});

it('can show the edit user page', function () {
    $response = $this->actingAs($this->user)->get(route('users.edit', $this->user));

    $response->assertStatus(200);
    $response->assertSee($this->user->name);
});

it('can update a user', function () {
    $updatedData = [
        'name' => 'Updated Name',
        'email' => $this->user->email,
        'password' => '',
        'password_confirmation' => '',
    ];

    $response = $this->actingAs($this->user)->patch(route('users.update', $this->user), $updatedData);

    $response->assertRedirect(route('users.index'));
    expect($this->user->refresh()->name)->toBe('Updated Name');
});

it('can delete a user', function () {
    $userToDelete = User::factory()->create();

    $response = $this->actingAs($this->user)->delete(route('users.destroy', $userToDelete));

    $response->assertRedirect(route('users.index'));
    $this->assertDatabaseMissing('users', ['id' => $userToDelete->id]);
});
