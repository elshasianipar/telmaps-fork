<?php

namespace App\Livewire\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.auth')]
#[Title('Masuk · TELF')]
class LoginPage extends Component
{
    public string $email = '';

    public string $password = '';

    public bool $remember = false;

    public function login(): void
    {
        $validated = $this->validate([
            'email' => ['required', 'email', 'max:255'],
            'password' => ['required', 'string'],
        ]);

        if (! Auth::attempt([
            'email' => $validated['email'],
            'password' => $validated['password'],
        ], $this->remember)) {
            $this->addError('email', 'Email atau kata sandi salah.');
            $this->reset('password');

            return;
        }

        if (request()->hasSession()) {
            request()->session()->regenerate();
        }

        /** @var User $user */
        $user = Auth::user();
        $this->redirectIntended($user->isAdmin() ? route('admin.about') : route('home'));
    }

    public function render()
    {
        return view('livewire.auth.login-page');
    }
}
