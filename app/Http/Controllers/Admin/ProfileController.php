<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;

class ProfileController extends Controller {

    public function showProfileForm() {
        $user = Auth::guard('web')->user();
        return view('Admin.Profile_form', ['user' => $user]);
    }

    public function changeDetails(Request $request) {
        $user = Auth::guard('web')->user();
        $this->validateForm($request);
        $this->validateEmail($request, $user);
        $update = $request->all();
        $update['password'] = bcrypt($request->password);
        $user->update($update);
        return redirect()->back()->with('success', 'Your profile has been updated');
    }

    private function validateForm(Request $request) {
        return $this->validate($request, [
                    'name' => 'required|max:255',
                    'email' => 'required',
                    'password' => 'required|min:4|confirmed'
        ]);
    }

    private function validateEmail(Request $request, $user) {
        if ($user->email != $request->email) {
            return $this->validate($request, [
                        'email' => 'required|email|max:255|unique:users'
            ]);
        }
    }

}
