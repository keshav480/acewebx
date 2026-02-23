<?php

namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\LoginOtpMail;
use Illuminate\Support\Facades\hash;
use App\Notifications\NewUserRegisteredNotification;
use Illuminate\Support\Facades\Notification;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }
        public function showRegistrationForm()
        {
            return view('auth.register');
        }
    
 public function login(Request $request)
{
    /*
    |--------------------------------------------------------------------------
    | STEP 2 → VERIFY OTP FIRST
    |--------------------------------------------------------------------------
    */
    if ($request->filled('otp')) {
        $request->validate([
            'otp' => ['required', 'digits:6']
        ]);
        $user = User::where('email', session('login_email'))
                    ->where('otp', $request->otp)
                    ->first();
        if (!$user) {
            return back()->with('error', 'Invalid OTP');
        }
        $user->update([
            'otp' => null
        ]);
        Auth::login($user);
        $request->session()->forget(['otp_sent', 'login_email']);
        if ($user->role === 'admin') {
            return redirect()->intended(route('admin.dashboard'));
        }
        return redirect()->intended(route('home'));
    }
    /*
    |--------------------------------------------------------------------------
    | STEP 1 → EMAIL + PASSWORD LOGIN
    |--------------------------------------------------------------------------
    */
    $credentials = $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required'],
    ]);
    if (Auth::attempt($credentials)) {
        $user = Auth::user();
        $otp = random_int(100000, 999999);
        $user->update([
            'otp' => $otp
        ]);
        Mail::to($user->email)->send(new LoginOtpMail($otp));
        Auth::logout();
        session([
            'otp_sent' => true,
            'login_email' => $user->email
        ]);
        return back()->with('success', 'OTP sent to your email.');
    }
    return back()->withErrors([
        'email' => 'Invalid credentials',
    ]);
}

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => ['required','string','max:255'],
            'email' => ['required','email','unique:users,email'],
            'password' => ['required','confirmed','min:6'],
        ]);
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
        $admins = User::where('role', 'admin')->get();
            foreach ($admins as $admin) {
                $admin->notify(new NewUserRegisteredNotification($user));
            }
        return redirect()->route('login')->with('success', 'Registration successful. Please login.');
    }


     public function destroy(Request $request)
    {
        Auth::guard('web')->logout(); 
        $request->session()->invalidate(); 
        $request->session()->regenerateToken(); 
        return redirect('/'); 
    }
    public function cancelOtp()
    {
        session()->forget('otp_sent');
        session()->forget('otp_code');
        session()->forget('otp_email');

        return redirect()->route('login');
    }
}
