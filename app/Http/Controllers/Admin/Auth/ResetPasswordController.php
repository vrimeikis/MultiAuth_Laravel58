<?php

declare(strict_types = 1);

namespace App\Http\Controllers\Admin\Auth;

use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Illuminate\View\View;

class ResetPasswordController extends Controller
{
    use ResetsPasswords;

    /**
     * @var string
     */
    protected $redirectTo = '/admin';

    /**
     * ResetPasswordController constructor.
     */
    public function __construct() {
        $this->middleware('guest:admin');
    }

    /**
     * Get the broker to be used during password reset.
     *
     * @return \Illuminate\Contracts\Auth\PasswordBroker
     */
    public function broker() {
        return Password::broker('admins');
    }

    /**
     * @param Request $request
     * @param null $token
     *
     * @return View
     */
    public function showResetForm(Request $request, $token = null): View {
        return view('admin.auth.passwords.reset',
            [
                'token' => $token,
                'email' => $request->email,
            ]
        );
    }

    /**
     * Get the guard to be used during password reset.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard() {
        return Auth::guard('admin');
    }
}
