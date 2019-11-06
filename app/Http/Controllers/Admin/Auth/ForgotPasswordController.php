<?php

declare(strict_types = 1);

namespace App\Http\Controllers\Admin\Auth;

use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Password;
use Illuminate\View\View;

class ForgotPasswordController extends Controller
{
    use SendsPasswordResetEmails;

    /**
     * ForgotPasswordController constructor.
     */
    public function __construct() {
        $this->middleware('guest:admin');
    }

    /**
     * @return View
     */
    public function showLinkRequestForm(): View
    {
        return view('admin.auth.passwords.email');
    }

    /**
     * Get the broker to be used during password reset.
     *
     * @return \Illuminate\Contracts\Auth\PasswordBroker
     */
    public function broker() {
        return Password::broker('admins');
    }
}
