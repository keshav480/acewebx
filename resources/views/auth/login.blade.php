<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">

    <div class="bg-white shadow-lg rounded-lg p-8 w-full max-w-md">
        <h1 class="text-2xl font-bold mb-6 text-center">Login</h1>

        @if($errors->any())
            <div class="bg-red-100 text-red-700 p-2 rounded mb-4">
                {{ $errors->first() }}
            </div>
        @endif

      <form method="POST" action="{{ route('login') }}">
    @csrf

    {{-- Success message --}}
    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-2 mb-3">
            {{ session('success') }}
        </div>
    @endif

    {{-- Error message --}}
    @if(session('error'))
        <div class="bg-red-100 text-red-700 p-2 mb-3">
            {{ session('error') }}
        </div>
    @endif

    {{-- STEP 1: Normal Login --}}
    @if(!session('otp_sent'))

        <div class="mb-4">
            <label>Email</label>
            <input type="email" name="email"
                   class="w-full p-2 border rounded" required>
        </div>
        <div class="mb-4">
            <label>Password</label>
            <input type="password" name="password"
                   class="w-full p-2 border rounded" required>
        </div>
        <button type="submit"
            class="w-full bg-blue-600 text-white py-2 rounded">
            Login
        </button>
    @else
    {{-- STEP 2: OTP Input --}}
        <div class="mb-4">
            <label>Enter OTP sent to your email</label>

            <input type="text" name="otp"
                class="w-full p-2 border rounded"
                placeholder="6 digit code"
                required>
        </div>
        <button type="submit"
            class="w-full bg-green-600 text-white py-2 rounded">
            Verify OTP
        </button>
    {{-- ✅ Back to Login Button --}}
    <div class="mt-3 text-center">
        <a href="{{ route('cancel.otp') }}">← Back to Login</a>
    </div>
    @endif
        <p class="text-sm mt-4 text-center">
            Don't have an account? <a href="{{ route('register') }}" class="text-blue-600 hover:underline">Register</a>
        </p>
</form>

    </div>

</body>
</html>
