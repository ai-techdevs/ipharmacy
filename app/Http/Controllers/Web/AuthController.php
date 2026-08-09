<?php

namespace App\Http\Controllers\Web;

use Brian2694\Toastr\Facades\Toastr;
use App\Http\Requests\Web\LoginRequest;
use App\Http\Requests\Web\RegistrationRequest;
use App\Models\EmailVerification;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\RegistrationOtpMail;
use App\Models\EmailTemplate;
use App\Mail\SendEmail;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Mail as Email;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

use App\Models\Subscription;
use App\Models\SubscriptionFeature;
use App\Models\SubscriptionUserDetail;
use App\Models\Transaction;
use App\Traits\HelperTrait;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;

class AuthController extends Controller
{
    // use HelperTrait;

    // private function sendEmailVerificationEmail($user)
    // {
    //     //sending email for verification
    //     while(true)
    //     {
    //         $token = Str::random(64);
    //         if(empty(EmailVerification::where("token", $token)->first()))
    //         {
    //             break;
    //         }
    //     }
    //     $emailVerification = EmailVerification::where("email", $user->email)->first();
    //     if(empty($emailVerification))
    //     {
    //         EmailVerification::create([
    //             "email" => $user->email,
    //             "token" => $token,
    //             "expire_at" => Carbon::now()->addHours(3),
    //         ]);
    //     }
    //     else
    //     {
    //         $emailVerification->update([
    //             "email" => $user->email,
    //             "token" => $token,
    //             "expire_at" => Carbon::now()->addHours(3),
    //         ]);
    //     }
    //     $mail_template      = EmailTemplate::where('email_type', 'user_email_verification')->first();
    //     $message            = $mail_template->content;
    //     $search = array('[name]','[link]','[site_name]','[logo]');
    //     $replace = array($user->name, route("verify.email", [$token]), \App\Utils\Helper::setting('web_app_name'), ( empty(\App\Utils\Helper::setting('web_app_logo')) || !file_exists(public_path("storage/".\App\Utils\Helper::setting('web_app_logo'))) ) ? asset("assets/images/default_images/logo.png") :  asset("storage/".\App\Utils\Helper::setting('web_app_logo')));
    //     $message = str_replace($search, $replace, $message);

    //     $data['name']= $user->name;
    //     $data['email']= $user->email;
    //     $data['attachments'] = '';
    //     $data['link'] = route("verify.email", [$token]);
    //     //$data['subject'] = $mail_template->subject;

    //     $data['subject'] ="Verify Your Email. Hello " .$user->name. ", you're almost there! Just one last step to go.";
    //     $data['content'] = $message;
    //     $data['template_file_path'] = "web.mails.email_template";
    //     Email::to($data['email'])->send(new SendEmail($data));
    // }



    // public function registration()
    // {
    //     if(!\Auth::check())
    //     {
    //         $countries = DB::table('countries')->orderBy('name')->get();
    //         return view('web.auth.registration',compact('countries'));
    //     }
    //     return redirect()->route('index');
    // }

    public function doRegistration(RegistrationRequest $request)
    {
        $data = $request->validated();
        // dd($data);
        try {
            DB::beginTransaction();

            $response = Http::withOptions(['verify' => false])->asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
                'secret' => env('NOCAPTCHA_SECRET'),
                'response' => $request->input('g-recaptcha-response'),
                'remoteip' => $request->ip(),
            ]);

            $result = $response->json();

            if (!($result['success'] ?? false)) {
                return back()->withErrors(['g-recaptcha-response' => 'Captcha verification failed.'])->withInput();
            }

            $user = User::create([
                'name'      => $data['first_name'],
                'role_id'   => Role::USER,
                'last_name' => $data['last_name'],
                'email'     => $data['email'],
                'mobile'    => $data['mobile'],
                'age_group' => $data['age_group'],
                'gender'    => $data['gender'],
                'address1'  => $data['address1'],
                'address2'  => $data['address2'] ?? null,
                'city'      => $data['city'],
                'state'     => $data['state'],
                'zip'       => $data['zip'],
                'password'  => Hash::make($data['password']),
            ]);


            $plainOtp = str_pad((string)random_int(0, 999999), 6, '0', STR_PAD_LEFT);
            $user->otp = Hash::make($plainOtp);

            $user->otp_expires_at = now()->addMinutes(2);
            $user->save();
            session([
                'registration_user_id' => $user->id,
                'registration_email'   => $user->email,
                'registration_otp'     => $plainOtp, // 👈 add this line
            ]);

            Mail::to($user->email)->send(new RegistrationOtpMail($plainOtp));


            session([
                'registration_user_id' => $user->id,
                'registration_email'   => $user->email,
            ]);

            DB::commit();

            Toastr::success('Registration successful. OTP sent to your email.', 'Success');
            return redirect()->route('otp.verify.form');
        } catch (\Throwable $e) {
            DB::rollBack();

            Toastr::error($e->getMessage(), 'Error');
            \Log::error('Registration failed: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'input' => $request->except('password', 'password_confirmation'),
            ]);

            return redirect()->back()->withInput();
        }
    }

    // public function doRegistration(RegistrationRequest $request)
    // {
    //     $data = $request->validated();

    //     try {
    //         DB::beginTransaction();

    //         $user = User::create([
    //             'name' => $data['first_name'],
    //             'role_id' => Role::USER,
    //             'last_name'  => $data['last_name'],
    //             'email'      => $data['email'],
    //             'mobile'     => $data['mobile'],
    //             'age_group'  => $data['age_group'],
    //             'gender'     => $data['gender'],
    //             'address1'   => $data['address1'],
    //             'address2'   => $data['address2'] ?? null,
    //             'city'       => $data['city'],
    //             'state'      => $data['state'],
    //             'zip'        => $data['zip'],
    //             'password'   => Hash::make($data['password']),
    //         ]);
    //         $plainOtp = str_pad((string)random_int(0, 999999), 6, '0', STR_PAD_LEFT);
    //         $user->otp = Hash::make($plainOtp);
    //         $user->otp_expires_at = now()->addMinutes(10);
    //         $user->save();

    //         Mail::to($user->email)->send(new RegistrationOtpMail($plainOtp));

    //         // store user id in session to refer on OTP page
    //         session(['registration_user_id' => $user->id]);
    //         session(['registration_email' => $user->email]);
    //         DB::commit();


    //         // if (method_exists($user, 'sendEmailVerificationNotification')) {
    //         //     $user->sendEmailVerificationNotification();
    //         // }
    //         //Toastr::success('Registration successful.', 'Success');
    //         //return redirect()->route('login')->with('success', 'Registration successful.');
    //         return redirect()->route('otp.verify.form')->with('success', 'OTP sent to your email.');
    //     } catch (\Throwable $e) {
    //         DB::rollBack();
    //         Toastr::error($e->getMessage(), "Error");
    //         \Log::error('Registration failed: ' . $e->getMessage(), [
    //             'trace' => $e->getTraceAsString(),
    //             'input' => $request->except('password', 'password_confirmation'),
    //         ]);

    //         return redirect()->back()
    //             ->withInput()
    //             ->withErrors(['general' => 'Registration failed, please try again.']);
    //     }
    // }


    public function showForm(Request $request)
    {

        $activeTab = $request->routeIs('registration') ? 'signup' : 'login';
        return view('web.auth.login', compact('activeTab'));
    }


    // public function doLogin(LoginRequest $request)
    // {
    //     $credentials = $request->only('email', 'password');
    //     $credentials['status'] = 1;
    //     $credentials['role_id'] = 3;
    //     if (\Auth::attempt($credentials, true)) {

    //         if (session('redirect_url')) {
    //             return redirect(session('redirect_url'));
    //         }
    //         return redirect()->route('dashboard');
    //     }

    //     return redirect()->route('login')->withErrors(['email' => 'Invalid Username/password.'])->withInput();

    //     // Toastr::error('Invalid Username/password.', 'Error');
    //     // return redirect()->route('login')->withInput();
    // }
    public function doLogin(LoginRequest $request)
    {
        //         $credentials = $request->only('email', 'password');
        //         $credentials['status'] = 1;
        //         $credentials['role_id'] = Role::USER;
        //         $credentials['is_verified'] = true;
        // // dd( $credentials);
        //         if (Auth::attempt($credentials, true)) {
        //             Toastr::success('Welcome back!', 'Login Successful');

        //             if (session('redirect_url')) {
        //                 return redirect(session('redirect_url'));
        //             }
        //             return redirect()->route('dashboard');
        //         }

        //         Toastr::error('Invalid Username or Password', 'Login Failed');
        //         return redirect()->route('login')->withInput();

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials, true)) {
            $user = Auth::user();
// dd($user);
            if ($user->status != 1 || $user->role_id != Role::USER || !$user->is_verified) {
                Auth::logout();
                Toastr::error('Your account is not active or verified.', 'Login Failed');
                return redirect()->route('login')->withInput();
            }

            Toastr::success('Welcome back!', 'Login Successful');

            if (session('redirect_url')) {
                return redirect(session('redirect_url'));
            }
            return redirect()->route('dashboard');
        }

        Toastr::error('Invalid Username or Password', 'Login Failed');
        return redirect()->route('login')->withInput();
    }

    public function logout(Request $request)
    {
        \Auth::logout();
        $request->session()->invalidate();
        return redirect(route('login'));
    }

    public function showOtpForm()
    {
        return view('web.auth.otp');
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required|digits:6',
        ]);

        $userId = session('registration_user_id');
        if (!$userId) {
            return redirect()->route('register.form')->withErrors(['general' => 'Session expired, please register again.']);
        }

        $user = User::find($userId);
        if (!$user) {
            return redirect()->route('register.form')->withErrors(['general' => 'User not found.']);
        }

        if ($user->is_verified) {
            return redirect()->route('login')->with('success', 'Already verified, please login.');
        }

        if (!$user->otp_expires_at || now()->greaterThan($user->otp_expires_at)) {
            return back()->withErrors(['otp' => 'OTP expired, please resend.']);
        }

        if (!Hash::check($request->input('otp'), $user->otp)) {
            return back()->withErrors(['otp' => 'Invalid OTP.']);
        }


        $user->is_verified = true;
        $user->otp = null;
        $user->otp_expires_at = null;
        $user->save();

        // optional: log them in
        \Auth::login($user);

        return redirect()->route('dashboard')->with('success', 'Email verified and registration complete.');
    }


    public function resendOtp(Request $request)
    {
        $userId = session('registration_user_id');
        if (!$userId) {
            return response()->json(['error' => 'Session expired, please register again.'], 422);
        }

        $user = User::find($userId);
        if (!$user) {
            return response()->json(['error' => 'User not found.'], 404);
        }


        $plainOtp = str_pad((string)random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        $user->otp = Hash::make($plainOtp);
        $user->otp_expires_at = now()->addMinutes(2);
        $user->save();

        Mail::to($user->email)->send(new RegistrationOtpMail($plainOtp));

        return response()->json(['success' => 'OTP resent to your email.']);
    }

    public function profileUpdate(Request $request)
    {
        $user = Auth::user();


        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name'  => 'nullable|string|max:255',
            'email'      => 'required|email|unique:users,email,' . $user->id,
            'mobile'     => 'nullable|string|max:20',
            'age_group'  => 'nullable|string',
            'gender'     => 'nullable|string',
            'address1'   => 'nullable|string|max:255',
            'address2'   => 'nullable|string|max:255',
            'city'       => 'nullable|string|max:100',
            'state'      => 'nullable|string|max:100',
            'zip'        => 'nullable|string|max:20',


            'existing_conditions'   => 'nullable|string|max:255',
            'current_medications'   => 'nullable|string|max:255',
            'known_allergies'       => 'nullable|string|max:255',
            'previous_surgeries'    => 'nullable|string|max:255',

            'image'     => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);


        $user->name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        $user->mobile = $request->mobile;
        $user->age_group = $request->age_group;
        $user->gender = $request->gender;
        $user->address1 = $request->address1;
        $user->address2 = $request->address2;
        $user->city = $request->city;
        $user->state = $request->state;
        $user->zip = $request->zip;


        $user->existing_medical_conditions = $request->existing_conditions;
        $user->currently_taking_medications = $request->current_medications;
        $user->known_allergies = $request->known_allergies;
        $user->previous_surgeries = $request->previous_surgeries;


        if ($request->hasFile('image')) {

            if ($user->image && Storage::exists('public/' . $user->image)) {
                Storage::delete('public/' . $user->image);
            }

            $path = $request->file('image')->store('profile-images', 'public');
            $user->image = $path;
        }

        $user->save();

        return redirect()->back()->with('success', 'Profile updated successfully!');
    }


    //     public function verifyEmail($token)
    //     {
    //         $emailVerification = EmailVerification::where("token", $token)->first();
    //         if(empty($emailVerification))
    //         {
    //             return view("errors.410");
    //         }
    //         $expireAt = Carbon::parse($emailVerification->expire_at);
    //         $user = User::where("email", $emailVerification->email)->first();
    //         if(empty($user))
    //         {
    //             return view("errors.410")->with(["message" => "Account not found."]);
    //         }
    //         if(Carbon::now()->greaterThan($expireAt))
    //         {
    //             $this->sendEmailVerificationEmail($user);
    //             Toastr::success('Link Expired!!!, we sent an email again', 'Success');
    //             return redirect(route('login'));
    //         }
    //         $user->update([
    //             "email_verified_at" => Carbon::now()
    //         ]);
    //         $emailVerification->delete();
    //         Toastr::success('Email Verified Successfully, please login now.', 'Success');
    //         return redirect()->route('login')->withInput();
    //     }


    //     public function verifyEmailAdmin($token)
    //     {
    //         $emailVerification = EmailVerification::where("token", $token)->first();
    //         if(empty($emailVerification))
    //         {
    //             return view("errors.410");
    //         }
    //         $expireAt = Carbon::parse($emailVerification->expire_at);
    //         $user = User::where("email", $emailVerification->email)->first();
    //         if(empty($user))
    //         {
    //             return view("errors.410")->with(["message" => "Account not found."]);
    //         }
    //         if(Carbon::now()->greaterThan($expireAt))
    //         {
    //             $this->sendEmailVerificationEmail($user);
    //             Toastr::success('Link Expired!!!, we sent an email again', 'Success');
    //             return redirect(route('login'));
    //         }
    //         $user->update([
    //             "email_verified_at" => Carbon::now()
    //         ]);
    //         //$emailVerification->delete();
    //         Toastr::success('Email Verified Successfully, please login now.', 'Success');
    //         return redirect()->route('password.create', ['token' => $token]);

    //     }

    //     public function verifyEmailSubAdmin($token)
    //     {
    //         $emailVerification = EmailVerification::where("token", $token)->first();
    //         if(empty($emailVerification))
    //         {
    //             return view("errors.410");
    //         }
    //         $expireAt = Carbon::parse($emailVerification->expire_at);
    //         $user = User::where("email", $emailVerification->email)->first();
    //         if(empty($user))
    //         {
    //             return view("errors.410")->with(["message" => "Account not found."]);
    //         }
    //         if(Carbon::now()->greaterThan($expireAt))
    //         {
    //             $this->sendEmailVerificationEmail($user);
    //             Toastr::success('Link Expired!!!, we sent an email again', 'Success');
    //             return redirect(route('login'));
    //         }
    //         $user->update([
    //             "email_verified_at" => Carbon::now()
    //         ]);
    //         //$emailVerification->delete();
    //         Toastr::success('Email Verified Successfully, please login now.', 'Success');
    //         return redirect()->route('admin.password.create', ['token' => $token]);

    //     }

    //     public function passwordCreate($token)
    // {

    //     return view('web.auth.password-create', compact('token'));
    // }

    // public function passwordCreateAdmin($token)
    // {

    //     return view('admin.auth.password-create', compact('token'));
    // }


    //     // public function logout(Request $request)
    //     // {
    //     //     \Auth::logout(); // log the user out of our application
    //     //     $request->session()->invalidate();
    //     //     Toastr::success('Logout Successfully..', 'Success');
    //     //     return redirect(route('login')); // redirect the user to the login screen
    //     // }

    //     public function passwordStore(Request $request)
    //     {
    //        // try{
    //       // dd($request->all());
    //        //$user=User::find($);
    //        $emailVerification = EmailVerification::where("token", $request->token)->first();
    //        if(empty($emailVerification))
    //        {
    //            return view("errors.410");
    //        }

    //        $user = User::where("email", $emailVerification->email)->first();
    //        if(empty($user))
    //        {
    //            return view("errors.410")->with(["message" => "Account not found."]);
    //        }

    //        $request->validate([
    //         // 'email' => 'required|email|exists:users',
    //         'password' => 'required|string|min:6|confirmed',
    //         'password_confirmation' => 'required'
    //     ]);




    //     $user = User::where('email', $emailVerification->email)
    //                 ->update(['password' => Hash::make($request->password)]);
    //     $emailVerification->delete();
    //     Toastr::success('Password Updated Successfully.', 'Success');

    //     return redirect()->route('login');

    //         // }
    //         // catch(\Exception $e)
    //         // {
    //         //     DB::rollback();
    //         //     Toastr::error($e->getMessage(), "Error");
    //         //     return redirect(route('registration'));
    //         // }
    //     }


    //     public function passwordStoreAdmin(Request $request)
    //     {
    //        // try{
    //       // dd($request->all());
    //        //$user=User::find($);
    //        $emailVerification = EmailVerification::where("token", $request->token)->first();
    //        if(empty($emailVerification))
    //        {
    //            return view("errors.410");
    //        }

    //        $user = User::where("email", $emailVerification->email)->first();
    //        if(empty($user))
    //        {
    //            return view("errors.410")->with(["message" => "Account not found."]);
    //        }

    //        $request->validate([
    //         // 'email' => 'required|email|exists:users',
    //         'password' => 'required|string|min:6|confirmed',
    //         'password_confirmation' => 'required'
    //     ]);




    //     $user = User::where('email', $emailVerification->email)
    //                 ->update(['password' => Hash::make($request->password)]);
    //     $emailVerification->delete();
    //     Toastr::success('Password Updated Successfully.', 'Success');

    //     return redirect()->route('admin.login');

    //         // }
    //         // catch(\Exception $e)
    //         // {
    //         //     DB::rollback();
    //         //     Toastr::error($e->getMessage(), "Error");
    //         //     return redirect(route('registration'));
    //         // }
    //     }





    // //Password Update Function
    // public function doChangePassword(Request $request, $token)
    // {
    //     try{
    //         DB::beginTransaction();
    //         $validator = \Validator::make($request->all(), [
    //             'password' => 'required',
    //             'confirm_password' => 'required|same:password',
    //         ]);
    //         if ($validator->fails()) {
    //             return redirect()->back()->withErrors($validator)->withInput();
    //         }
    //         $passwordResetToken = PasswordResetToken::where("token", $token)->first();
    //         if(empty($passwordResetToken))
    //         {
    //             return view("errors.410");
    //         }
    //         $user = User::where("email",$passwordResetToken->email)->first();
    //         if(empty($user)){
    //             return redirect()->back()->withErrors(["password" => "User not found, please contact with admin"]);
    //         }
    //         if(in_array($user->role_id, [Role::$ADMIN, Role::$SUB_ADMIN])){
    //             return redirect()->back()->withErrors(["password" => "User doesn't have permission to change password, please contact with admin"]);
    //         }
    //         $password = Hash::make($request->password);
    //         $user->update(['password' => $password]);
    //         PasswordResetToken::where("token", $token)->delete();
    //         DB::commit();
    //         Toastr::success('Password has been updated successfully.', 'Success');
    //         return redirect(route('index'));
    //     }
    //     catch(\Exception $e)
    //     {
    //         DB::rollback();
    //         Toastr::error($e->getMessage(), 'Error');
    //         return redirect(route('index'));
    //     }
    // }

    // // Show Admin Password Form
    // public function changePassword(Request $request, $token)
    // {
    //     $retrieveToken = PasswordResetToken::where("token", $token)->first();
    //     if(empty($retrieveToken))
    //     {
    //         return view("errors.410");
    //     }
    //     $changePasswordBannerQuery = Banner::where(["page_type" => "change_password", "status" => 1])->first();
    //     $changePasswordBanner = asset("resources/web/images/banner-bg-1.jpg");
    //     if(!empty($changePasswordBannerQuery->image_path) && file_exists(public_path("storage/".$changePasswordBannerQuery->image_path)))
    //     {
    //         $changePasswordBanner = asset("storage/".$changePasswordBannerQuery->image_path);
    //     }
    //     return view('web.auth.change_password')->with([
    //         "changePasswordBanner" => $changePasswordBanner,
    //         "token" => $token,
    //     ]);
    // }
    // public function submitForgetPassword(Request $request)
    // {
    //     try{
    //         DB::beginTransaction();
    //         $this->validate($request, [
    //             'email' => 'required|email',
    //         ]);
    //         $user = User::where([
    //             "email" => $request->email,
    //             "status" => 1,
    //         ])->first();
    //         if(empty($user)){
    //             return redirect()->back()->withErrors(["email" => "User not found."]);
    //         }
    //         $isTokenAvailable = true;
    //         while($isTokenAvailable)
    //         {
    //             $token = Str::random(64);
    //             $isTokenAvailable = !empty(PasswordResetToken::where("token", $token)->first());
    //         }
    //         $passwordResetToken = PasswordResetToken::where("email", $user->email)->first();
    //         if(empty($passwordResetToken))
    //         {
    //             PasswordResetToken::create([
    //                 "email" => $user->email,
    //                 "token" => $token,
    //             ]);
    //         }
    //         else
    //         {
    //             $passwordResetToken->where("email", $user->email)->update([
    //                 "email" => $user->email,
    //                 "token" => $token,
    //             ]);
    //         }
    //         $mail_template      = EmailTemplate::where('email_type', 'change_password')->first();
    //         $message            = $mail_template->content;
    //         $search = array('[name]','[link]','[site_name]','[logo]');
    //         $replace = array($user->name, route("change.password", [$token]), \App\Utils\Helper::setting('web_app_name'), ( empty(\App\Utils\Helper::setting('web_app_logo')) || !file_exists(public_path("storage/".\App\Utils\Helper::setting('web_app_logo'))) ) ? asset("resources/web/images/logo.png") :  asset("storage/".\App\Utils\Helper::setting('web_app_logo')));
    //         $message = str_replace($search, $replace, $message);

    //         $data['name']= $user->name;
    //         $data['email']= $user->email;
    //         $data['attachments'] = '';
    //         $data['link'] = route("change.password", [$token]);
    //         $data['subject'] = $mail_template->subject;
    //         $data['content'] = $message;
    //         $data['template_file_path'] = "mails.email_template";
    //         Email::to($data['email'])->send(new SendEmail($data));
    //         DB::commit();
    //         Toastr::success('Email has sent successfully.', 'Success');

    //         return redirect(route('forget.password'));
    //     }
    //     catch(\Exception $e)
    //     {
    //         DB::rollback();
    //         Toastr::error($e->getMessage(), 'Error');
    //         return redirect(route('forget.password'));
    //     }
    // }

    // // Show Admin Password Form
    // public function forgetPassword(Request $request)
    // {
    //     $forgetPasswordBannerQuery = Banner::where(["page_type" => "forget_password", "status" => 1])->first();
    //     $forgetPasswordBanner = asset("resources/web/images/banner-bg-1.jpg");
    //     if(!empty($forgetPasswordBannerQuery->image_path) && file_exists(public_path("storage/".$forgetPasswordBannerQuery->image_path)))
    //     {
    //         $forgetPasswordBanner = asset("storage/".$forgetPasswordBannerQuery->image_path);
    //     }
    //     return view('web.auth.forget_password')->with([
    //         "forgetPasswordBanner" => $forgetPasswordBanner
    //     ]);
    // }

    public function forgetPassword()
    {
        return view('web.auth.forget-password');
    }

    public function submitForgetPasswordForm(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);
        $user = User::where(['email' => $request->email, 'role_id' => Role::USER])->first();

        if (empty($user)) {
            Toastr::error('Invalid email', 'Error');
            return redirect()->back()->withInput();
        }
        $token = Str::random(64);

        try {

            DB::table('password_reset_tokens')->updateOrInsert(
                ['email' => $request->email],
                [
                    'token' => $token,
                    'created_at' => Carbon::now()
                ]
            );

            Mail::send('emails.forget-password', ['token' => $token], function ($message) use ($request) {
                $message->to($request->email);
                $message->subject('Reset Password');
            });
            Toastr::success('We have e-mailed your password reset link!', 'Success');
            return redirect()->back();
        } catch (\Exception $e) {
            Toastr::error($e->getMessage(), 'Error');
            return back()->with('Error', 'Something went wrong!' . $e);
        }
    }

    public function showResetPasswordForm($token)
    {
        return view('web.auth.reset-password', ['token' => $token]);
    }


    public function submitResetPasswordForm(Request $request)
    {


        $request->validate(
            [
                'email' => 'required|email|exists:users',
               // 'password' => 'required|string|min:7|regex:/^(?=.*[a-zA-Z])(?=.*\d)[A-Za-z\d]+$/|confirmed',
               'password' => 'required|string|min:7|regex:/^(?=.*[a-zA-Z])(?=.*\d)(?=.*[@$!%*#?&])?[A-Za-z\d@$!%*#?&]+$/|confirmed',
                'password_confirmation' => 'required'
            ],
            [
                'password.regex' => 'Passwords must contain both alphabetic and numeric characters.',
                'password.confirmed' => 'Password and confirm password does not match.',
                'password_confirmation.required' => 'The Confirm password field is required.',
            ]
        );

        //dd($request->all());

        $updatePassword = DB::table('password_reset_tokens')
            ->where([
                'email' => $request->email,
                'token' => $request->token
            ])
            ->first();

        //dd($updatePassword);

        if (!$updatePassword) {
            Toastr::error('Invalid token!', 'Error');
            return back()->withInput();
        }

        $user = User::where('email', $request->email)
            ->update(['password' => Hash::make($request->password)]);

        DB::table('password_reset_tokens')->where(['email' => $request->email])->delete();
        Toastr::success('Your password has been changed!', 'Success');
        return redirect()->route('login');
    }
}
