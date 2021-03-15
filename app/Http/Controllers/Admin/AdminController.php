<?php

namespace App\Http\Controllers\Admin;

use App\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;


class AdminController extends Controller
{
    public function dashboard()
    {
        return view('admin.dashboard');
    }

    public function login(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();
            //echo "<pre>"; print_r($data); die;
            $rules = [
                'email' => 'required|email|max:255',
                'password' => 'required'
            ];
            $customMessages = [
                'email.required' => 'Se requiere un correo.',
                'email.email' => 'Ingrese un correo válido.',
                'password.required' => 'Se requiere un password.'
            ];
            $this->validate($request, $rules, $customMessages);

            if (Auth::guard('admin')->attempt(['email' => $data['email'], 'password' => $data['password']])) {
                return redirect('admin/dashboard');
            } else {
                Session::flash('error_message', 'Correo o Password incorrectos');
                return redirect()->back();
            }
        }
        return view('admin.login');
    }

    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect('/admin');
    }
    public function settings()
    {
        //echo "<pre>"; print_r(Auth::guard('admin')->user()); die;
        //$admin = Auth::guard('admin')->user();
        //dd($admin);
        $adminDetails = Admin::where('email', Auth::guard('admin')->user()->email)->first();
        return view('admin.settings')->with(compact('adminDetails'));
    }
}


