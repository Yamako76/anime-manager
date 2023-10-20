<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{

    private const GUEST_USER_ID = 1;

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function guestLogin(): \Illuminate\Http\RedirectResponse
    {
        if (Auth::loginUsingId(self::GUEST_USER_ID)) {
            return redirect()->to('/anime-list');
        } else {
            return redirect()->to('/');
        }
    }
}
