<?php

declare(strict_types = 1);

namespace App\Http\Controllers\Admin\Auth;

use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = '/admin';

    /**
     * LoginController constructor.
     */
    public function __construct() {
        $this->middleware('guest:admin')->except('logout');
    }

    public function showLoginForm(): View {
        return view('admin.auth.login');
    }

    public function login(Request $request) {
        $this->validate($request, [
            $this->username() => 'required|string',
            'password' => 'required|min:6',
        ]);

        if (Auth::guard('admin')->attempt(
            [
                $this->username() => $request->{$this->username()},
                'password' => $request->password,
            ],
            $request->get('remember')
        )) {
            return redirect()->intended($this->redirectTo);
        }

        return $this->sendFailedLoginResponse($request);
    }

    public function logout(Request $request) {
        Auth::guard('admin')->logout();

        $request->session()->invalidate();

        return $this->loggedOut($request) ?: redirect('/');
    }
}
