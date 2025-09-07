<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     */
    protected $redirectTo = '/dashboard';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Validate the user login request.
     * We expect a single "login" field (email OR phone) + password.
     */
    protected function validateLogin(Request $request)
    {
        $request->validate([
            'login'    => ['required','string'],
            'password' => ['required','string'],
        ]);
    }

    /**
     * Build the credentials array for attempt().
     * Detect if "login" looks like an email; otherwise treat as phone.
     */
    protected function credentials(Request $request)
    {
        $login = $request->input('login');
        $field = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'phone';

        return [
            $field     => $login,
            'password' => $request->input('password'),
        ];
    }

    /**
     * The field name used by the login form.
     */
    public function username()
    {
        return 'login';
    }
}
