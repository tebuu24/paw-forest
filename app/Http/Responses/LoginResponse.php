<?php

namespace App\Http\Responses;

use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;

class LoginResponse implements LoginResponseContract
{
    public function toResponse($request)
    {
        // Pilnīgi visus (gan adminus, gan parastos) metam uz sākumlapu
        return redirect('/');
    }
    public function authenticate()
    {
    $this->ensureIsNotRateLimited();

    $user = \App\Models\User::where('email', $this->input('email'))
        ->orWhere('username', $this->input('email'))
        ->first();

    if ($user && $user->is_blocked) {
        throw \Illuminate\Validation\ValidationException::withMessages([
            'email' => __('Your account has been blocked by an administrator.'),
        ]);
    }

    if (! Auth::attempt($this->only('email', 'password'), $this->boolean('remember'))) {
        RateLimiter::hit($this->throttleKey());

        throw \Illuminate\Validation\ValidationException::withMessages([
            'email' => __('auth.failed'),
        ]);
    }

    RateLimiter::clear($this->throttleKey());
    }
}