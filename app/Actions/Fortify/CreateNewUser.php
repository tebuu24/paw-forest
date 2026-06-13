<?php

namespace App\Actions\Fortify;

use App\Concerns\PasswordValidationRules;
use App\Concerns\ProfileValidationRules;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Illuminate\Support\Facades\Hash;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules, ProfileValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:100'],
            'username' => ['required', 'string', 'max:50', 'unique:user,username'],
            'email' => ['required', 'email', 'unique:user,email'],
            'address' => ['nullable', 'string', 'max:255'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ])->validate();

        return User::create([
            'name' => $input['name'],
            'username' => $input['username'],
            'email' => $input['email'],
            'address' => $input['address'] ?? null,
            'password' => Hash::make($input['password']),
            'role' => 'user',
        ]);
    }
}
