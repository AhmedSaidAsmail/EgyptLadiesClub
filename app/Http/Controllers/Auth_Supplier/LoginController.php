<?php

namespace App\Http\Controllers\Auth_Supplier;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Auth;

class LoginController extends Controller {

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/supplier';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('guest', ['except' => 'logout']);
    }

    public function showLoginForm() {
        if (Auth::guard('supplier')->check()) {
            return redirect()->route('spplier.welcome');
        }
        return view('auth_supplier.login');
    }

    public function login(Request $request) {
        $this->validate($request, [
            'email' => 'required',
            'password' => 'required'
        ]);
        if (Auth::guard('supplier')->attempt(['email' => $request->email, 'password' => $request->password, 'confirm' => 1], $request->remember)) {
            return redirect()->route('spplier.welcome');
        }
        return redirect()->back()
                        ->withInput($request->only('email', 'remember'))
                        ->withErrors(['email' => 'Please check that you have entered your login and password correctly.']);
    }

    public function logout() {
        Auth::guard('supplier')->logout();
        return redirect()->route('supplier.login');
    }

}
