<?php

namespace App\Services;

class AuthService
{
    public function isAdmin(): bool
    {
        return auth()->check() && auth()->user()->role === 'admin';
    }

    public function isAuthenticated(): bool
    {
        return auth()->check();
    }

    public function redirectToLogin()
    {
        return redirect()->route('login');
    }
}