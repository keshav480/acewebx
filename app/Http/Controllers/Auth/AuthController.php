<?php

namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\LoginOtpMail;
use Illuminate\Support\Facades\hash;


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
    // STEP 2: OTP verification
    if ($request->filled('otp')) {

        $user = User::where('email', session('login_email'))
            ->where('otp', $request->otp)
            ->first();

        if (!$user) {
            return back()->with('error', 'Invalid OTP');
        }

        // OTP correct → login user
        $user->update(['otp' => null]);

        Auth::login($user);
        $request->session()->forget(['otp_sent','login_email']);

        return redirect()->intended(route('admin.dashboard'));
    }

    // STEP 1: Email + password login
    $credentials = $request->validate([
        'email' => ['required','email'],
        'password' => ['required'],
    ]);

    if (Auth::attempt($credentials)) {

        $user = Auth::user();

        // generate OTP
        $otp = random_int(100000, 999999);

        $user->update(['otp' => $otp]);

        // send email
        Mail::to($user->email)->send(new LoginOtpMail($otp));

        // logout until OTP verified
        Auth::logout();

        // store email + flag in session
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
        // Auth::login($user);
        return redirect()->route('login')->with('success', 'Registration successful. Please login.');
    }


     public function destroy(Request $request)
    {
        Auth::guard('web')->logout(); 
        $request->session()->invalidate(); 
        $request->session()->regenerateToken(); 
        return redirect('/'); 
    }

}
