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
}