<?php

namespace App\Http\Controllers\Admin\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Auth\LoginRequest;
use App\Models\Cdc;
use App\Models\Forum;
use App\Models\Medicine;
use App\Models\Role;
use App\Models\User;
use Carbon\Carbon;

class AuthController extends Controller
{
    public function login()
    {
        return view('admin.auth.login');
    }


    public function authenticate(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');
        $credentials['status'] = 1;
        $credentials['role_id'] = Role::ADMIN;

        if (\Auth::attempt($credentials, true)) {
            //return redirect()->route('admin.dashboard') ;
            if (in_array(auth()->user()->role_id, [Role::ADMIN, Role::SUB_ADMIN])) {
                return redirect()->route('admin.dashboard');
            } else {
                \Auth::logout();
                return redirect()->route('login')->withErrors(['email' => 'Unauthorized']);
            }
        }

        return redirect()->route('admin.login')->withErrors(['email' => 'Invalid Username/password.'])->withInput();
    }

    public function dashboard()
    {
        $cdcs=Cdc::where('status',1)->count();
        $forums=Forum::where('status',1)->count();
        $users=User::where('status',1)->count();
        $medicines=Medicine::where('status',1)->count();
        return view('admin.dashboard',compact('cdcs','forums','users','medicines'));
    }

    public function logout(Request $request)
    {
        \Auth::logout(); // log the user out of our application
        $request->session()->invalidate();
        return redirect(route('admin.login')); // redirect the user to the login screen
    }


     public function savePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:4|confirmed',
        ]);

        if (!\Hash::check($request->current_password, \Auth::user()->password)) {

            return redirect()->back()->withInput()->with('error', 'Current password is incorrect.');
        }

        \Auth::user()->update([
            'password' => \Hash::make($request->new_password),
        ]);


      return redirect(route('admin.change.password'))->with('success', 'Password has been change successfully.');
    }

    // Show Admin Password Form
    public function changePassword(Request $request)
    {
      return view('admin.auth.change-password');
    }

    public function forgetPassword()
    {
        return view('admin.auth.forget-password');
    }

     public function submitForgetPasswordForm(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);
        $user = User::where(['email'=> $request->email , 'role_id' => Role::ADMIN])->first() ;

        if(empty($user)){
            //Toastr::error('Invalid email', 'Error');
            return redirect()->back()->with('error', 'Invalid email');
        }
        $token = \Str::random(64);

        try {

            \DB::table('password_reset_tokens')->updateOrInsert(
                ['email' => $request->email],
                [
                    'token' => $token,
                    'created_at' => Carbon::now()
                ]
            );

            \Mail::send('emails.admin-forget-password', ['token' => $token], function ($message) use ($request) {
                $message->to($request->email);
                $message->subject('Reset Password');
            });
            //Toastr::success('We have e-mailed your password reset link!', 'Success');
            return redirect()->back()->with('success', 'We have e-mailed your password reset link!');
        } catch (\Exception $e) {
            //Toastr::error($e->getMessage(), 'Error');
            return back()->with('error', 'Something went wrong!' . $e->getMessage());
        }
    }

    public function showResetPasswordForm($token)
    {
        return view('admin.auth.reset-password', ['token' => $token]);
    }


    public function submitResetPasswordForm(Request $request)
    {


        $request->validate([
            'email' => 'required|email|exists:users',
            'password' => 'required|string|min:7|regex:/^(?=.*[a-zA-Z])(?=.*\d)[A-Za-z\d]+$/|confirmed',
            'password_confirmation' => 'required'
        ],
        [
            'password.regex' => 'Passwords must contain both alphabetic and numeric characters.',
            'password.confirmed' => 'Password and confirm password does not match.',
            'password_confirmation.required' => 'The Confirm password field is required.',
        ]);

         //dd($request->all());

        $updatePassword = \DB::table('password_reset_tokens')
            ->where([
                'email' => $request->email,
                'token' => $request->token
            ])
            ->first();

           // dd($updatePassword);

        if (!$updatePassword) {
            //Toastr::error('Invalid token!', 'Error');
            return back()->with('error', 'Invalid email');
        }

        $user = User::where('email', $request->email)
            ->update(['password' => \Hash::make($request->password)]);

       \DB::table('password_reset_tokens')->where(['email' => $request->email])->delete();
        //Toastr::success('Your password has been changed!', 'Success');
        return redirect()->route('admin.login')->with('success', 'Your password has been changed!');
    }
}
