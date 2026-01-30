<?php

use App\Models\User;

it('redirects unauthenticated users to the login page', function () {
    $response = $this->get('/dashboard');

    $response->assertStatus(302);
    $response->assertRedirect('/login');
});

it('allows authenticated users to access the dashboard', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->get('/dashboard');

    $response->assertStatus(200);
    $response->assertSee('Dashboard');
});

it('can login a user with valid credentials', function () {
    $user = User::factory()->create([
        'password' => bcrypt('password123'),
    ]);

    $response = $this->post('/login', [
        'email' => $user->email,
        'password' => 'password123',
    ]);

    $this->assertAuthenticatedAs($user);
    $response->assertRedirect('/dashboard');
});
