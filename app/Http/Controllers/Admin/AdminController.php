<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    public function dashboard()
    {
        return view('admin.admin_dashboard');
    }

    public function login(Request $request)
    {
        if ($request->isMethod('POST'))
        {
            // dd($request->all());
            $data = $request->all();

            $validator = Validator::make($request->all(), [
                'email'    => 'required|email',
                'password' => 'required',
            ]);
    
            if ($validator->fails()) {
                return redirect('/admin')->withErrors($validator)->withInput();
            } 
            else
            {
                if (Auth::guard('admin')->attempt(['email' => $data['email'], 'password' => $data['password']]))
                {
                    return redirect('admin/dashboard');
                }
                else 
                {
                    Session::flash('error_message', 'Invalid Email or Password');
                    return redirect()->back();
                }
            }
        }
        return view('admin.admin_login');
    }

    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect('/admin');
    }
}
