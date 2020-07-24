<?php

namespace App\Http\Controllers\Admin;

use App\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;

class AdminController extends Controller
{
    public function dashboard()
    {
        return view('admin.admin_dashboard');
    }

    public function getAdminDetails()
    {
        $data['menu'] = 'settings';
        $data['subMenu'] = 'admin-details';
        $data['adminDetails'] = $adminDetails = Admin::where(['email' => Auth::guard('admin')->user()->email])->first();
        // dd($adminDetails);

        return view('admin.admin_settings', $data);
    }

    public function updateAdminPassword(Request $request)
    {
        $data['adminDetails'] = $adminDetails = Admin::where(['email' => Auth::guard('admin')->user()->email])->first(['password']);
        // dd($request->all());

        $rules = array(
            'password'              => 'nullable|min:6|confirmed',
            'password_confirmation' => 'nullable|min:6'
        );
        $fieldNames = array(
            'password'              => 'Password',
            'password_confirmation' => 'Confirm Password'
        );

        $validator = Validator::make($request->all(), $rules);
        $validator->setAttributeNames($fieldNames);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        } else {
            $currentPassword      = $request->currentPassword;
            $password             = $request->password;
            $passwordConfirmation = $request->password_confirmation;

            // dd($currentPassword, $password, $passwordConfirmation);


            if (Hash::check($currentPassword, $adminDetails->password)) {
                if ($password === $passwordConfirmation) {
                    Admin::where(['email' => Auth::guard('admin')->user()->email])->update(['password' => Hash::make($password)]);

                    return redirect()->back()->with('success', 'Password updated successfully.');
                } else {
                    return redirect()->back()->with('error', 'New password and confirm password doesn\'t matched.');
                }
            } else {
                return redirect()->back()->with('error', 'Please enter the correct password.');
            }
        }
    }

    public function updateAdminDetails(Request $request)
    {
        // dd($request->all());

        $rules = array(
            'name'  => 'required',
            'photo' => 'mimes:jpeg,png,jpg,gif,svg|image|max:2048'
        );
        $fieldNames = array(
            'name'  => 'Name',
            'photo' => 'Photo'
        );

        $validator = Validator::make($request->all(), $rules);
        $validator->setAttributeNames($fieldNames);

        if ($validator->fails()) 
        {
            return back()->withErrors($validator)->withInput();
        } 
        else 
        {
            $admin = Admin::find(Auth::guard('admin')->user()->id, ['id', 'name', 'mobile', 'image']);

            $admin->name   = $request->name;
            $admin->mobile = $request->mobile;

            if ($request->hasFile('photo')) 
            {
                $photo = $request->file('photo');
                if (isset($photo)) 
                {
                    $fileName  = time() . '.' . $photo->getClientOriginalExtension();
                    $extension = strtolower($photo->getClientOriginalExtension());
                    $existingFileLocation = public_path('images/admin_image/profile/' . $admin->image);
                    $locationToUpload     = public_path('images/admin_image/profile/' . $fileName);

                    if (file_exists($existingFileLocation)) 
                    {
                        unlink($existingFileLocation);
                    }
                    if ($extension == 'png' || $extension == 'jpg' || $extension == 'jpeg' || $extension == 'gif' || $extension == 'bmp') 
                    {
                        $image = Image::make($photo)->resize(98, 98)->save($locationToUpload);
                        $admin->image = $fileName;
                    } 
                    else 
                    {
                        Session::flash('error', 'Invalid image format');
                        return redirect('admin/get-admin-details');
                    }
                }
            }
            // dd($fileName);
           
            $admin->save();
            Session::flash('success', 'Admin details updated successfully');
            return redirect('admin/get-admin-details');
        }
    }

    public function checkCurrentPassword(Request $request)
    {
        // dd($request->all());
        $currentPassword = $request->currentPassword;
        $adminPassword   = Admin::where(['email' => Auth::guard('admin')->user()->email])->first(['password']);
        // dd($adminPassword);

        if (Hash::check($currentPassword, $adminPassword->password)) {
            $data['status']  = true;
            $data['message'] = 'Password is correct.';
            return response()->json(['success' => $data]);
        } else {
            $data['status']  = false;
            $data['message'] = 'Password is incorrect.';
            return response()->json(['success' => $data]);
        }
    }

    public function login(Request $request)
    {
        if ($request->isMethod('POST')) {
            // dd($request->all());
            $data = $request->all();

            $validator = Validator::make($request->all(), [
                'email'    => 'required|email',
                'password' => 'required',
            ]);

            if ($validator->fails()) {
                return redirect('/admin')->withErrors($validator)->withInput();
            } else {
                if (Auth::guard('admin')->attempt(['email' => $data['email'], 'password' => $data['password']])) {
                    return redirect('admin/dashboard');
                } else {
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
