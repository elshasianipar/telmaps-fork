<?php

use App\Livewire\Auth\LoginPage;
use App\Livewire\Auth\RegisterPage;
use App\Models\User;
use Livewire\Livewire;

it('renders the login page for guests', function () {
    $this->get('/login')->assertOk()->assertSee('Masuk');
});

it('renders the register page for guests', function () {
    $this->get('/register')->assertOk()->assertSee('Daftar Akun');
});

it('logs an admin in and redirects to the admin panel', function () {
    $admin = User::factory()->create(['role' => 'admin', 'password' => 'password']);

    Livewire::test(LoginPage::class)
        ->set('email', $admin->email)
        ->set('password', 'password')
        ->call('login')
        ->assertRedirect(route('admin.about'));

    $this->assertAuthenticatedAs($admin);
});

it('rejects invalid credentials', function () {
    $user = User::factory()->create(['role' => 'admin', 'password' => 'password']);

    Livewire::test(LoginPage::class)
        ->set('email', $user->email)
        ->set('password', 'wrong-password')
        ->call('login')
        ->assertHasErrors(['email']);

    $this->assertGuest();
});

it('redirects a non-admin user to home after login', function () {
    $viewer = User::factory()->create(['role' => 'viewer', 'password' => 'password']);

    Livewire::test(LoginPage::class)
        ->set('email', $viewer->email)
        ->set('password', 'password')
        ->call('login')
        ->assertRedirect(route('home'));
});

it('logs a user out', function () {
    $user = User::factory()->create();

    $this->actingAs($user)->post('/logout')->assertRedirect(route('home'));
    $this->assertGuest();
});

it('registers a new viewer and logs them in', function () {
    Livewire::test(RegisterPage::class)
        ->set('name', 'Pengguna Baru')
        ->set('email', 'new@example.com')
        ->set('password', 'password')
        ->set('password_confirmation', 'password')
        ->call('register')
        ->assertRedirect(route('home'));

    $this->assertDatabaseHas('users', [
        'email' => 'new@example.com',
        'role' => User::ROLE_VIEWER,
    ]);
    $this->assertAuthenticated();
});
