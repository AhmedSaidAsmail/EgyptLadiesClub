<?php

namespace App\Http\Controllers\Auth_Supplier;

use App\Supplier;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Mail\registerConfirmation;
use Exception;

class RegisterController extends Controller {

    protected $redirectTo = '/';

    public function __construct() {
        $this->middleware('guest');
    }

    public function index() {
        return view('auth_supplier.Welcome');
    }

    public function showRegisterForm() {
        return view('auth_supplier.registerForm');
    }

    public function register(Request $request) {
        $this->validator($request);
        $register = $this->create($request);
        if(!$register){
            return $register;
        }
        $this->sendConfirmationMail($request->email, $register->id, $register->rand_code);
        return redirect()->route('supplier.index')->with('confirmMail', 'an email confirmaion has benn sent to ' . $request->email . ' ,Please check your inbox and click the confirmation link');
    }

    public function registerConfirmation($id, $rand_code) {
        $this->checkLink($id, $rand_code);
        return view('auth_supplier.setPassword', ['id' => $id]);
    }

    public function setPassword(Request $request, $id) {
        $this->validate($request, [
            'password' => 'required|min:6|confirmed',
        ]);
        $supplier = Supplier::find($id);
        $supplier->update(['password' => bcrypt($request->password), 'confirm' => 1]);
        return redirect()->route('supplier.login');
    }

    protected function validator(Request $request) {
        return $this->validate($request, [
                    'f_name' => 'required|max:255',
                    'l_name' => 'required|max:255',
                    'email' => 'required|email|max:255|unique:suppliers',
                    'mobile' => 'required',
                    'company' => 'required',
                    'store_name' => 'required|max:255',
                    'address' => 'required|max:255',
                    'city' => 'required',
        ]);
    }

    protected function create(Request $request) {
        $data = $request->all();
        $data['confirm'] = 0;
        $data['rand_code'] = md5(uniqid(rand(), TRUE));
        try {
            Supplier::create($data);
            return true;
        } catch (Exception $ex) {
            return redirect()->back()->with('failure', $ex->getMessage());
        }
    }

    protected function sendConfirmationMail($email, $id, $remmber_token) {
        Mail::to($email)->send(new registerConfirmation($id, $remmber_token));
    }

    protected function checkLink($id, $rand_code) {
        $supplier = Supplier::find($id);
        if ($supplier->rand_code !== $rand_code) {
            throw new Exception('This Link is not valid');
        }
        elseif ($supplier->confirm !== 0 && !is_null($supplier->password)) {
            throw new Exception('This Link already used before');
        }
    }

}
