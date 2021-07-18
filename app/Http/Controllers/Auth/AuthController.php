<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use App\Notifications\RegistrationEmailNotification;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth', ['only' => 'logout']);
    // }
    public function showRegistrationForm()
    {
        return view('frontend.auth.register');
    }

    public function processRegistration(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'phone_number' => 'required|min:11|max:13|unique:users,phone_number',
            'password' => 'required|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data = [
            'name' => trim($request->name),
            'email' => strtolower(trim($request->email)),
            'phone_number' => trim($request->phone_number),
            'password' => bcrypt($request->password),
            'email_verification_token' => uniqid(time(), true) . str_random(16),
        ];

        try {
            $user = User::create($data);

            $user->notify(new RegistrationEmailNotification($user));

            $this->setSuccess('User Created');
            return redirect()->route('login');
        } catch (Exception $e) {

            $this->setDanger($e->getMessage());

            return redirect()->back();
        }
    }

    public function activate($token = null)
    {
        if ($token == null) {
            return redirect('/');
        } else {
            $user = User::where('email_verification_token', $token)->firstOrFail();
            if ($user) {
                $user->update([
                    'email_verified_at' => Carbon::now(),
                    'email_verified' => 1,
                    'email_verification_token' => null
                ]);
                $this->setSuccess('Activation successful, you can login now.');
                return redirect()->route('login');
            }

            $this->setError('Invalid Token');
            return redirect()->back();
        }
    }

    public function showLoginForm()
    {
        return view('frontend.auth.login');
    }

    public function processLogin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $credentials = $request->only('email', 'password');

        if (auth()->attempt($credentials)) {
            $user = auth()->user();
            //$user->last_login = Carbon::now();
            //$user->save();

            if ($user->email_verified === 0) {
                $this->setDanger('Your account is not verified yet');
                auth()->logout();

                return redirect()->route('login');
            }

            $this->setSuccess('User Logged in');
            return redirect()->intended();
        }


        $this->setDanger('Invalid Credentials');
        return redirect()->back();
    }
    public function logout()
    {
        auth()->logout();
        return redirect('/');
    }
    public function profile()
    {
        $data = [];
        $data['orders'] = Order::where('user_id', auth()->user()->id)->get();
        return view('frontend.auth.profile', $data);
    }
}