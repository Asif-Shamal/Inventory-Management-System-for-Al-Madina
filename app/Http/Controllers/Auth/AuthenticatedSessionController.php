<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Providers\RouteServiceProvider;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Validation\ValidationException;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     *
     * @param  \App\Http\Requests\Auth\LoginRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(LoginRequest $request)
    {
        // From here on 
        // Define the validation rules
        $rules = [
            'username' => 'required|string',
            'password' => 'required|string',
        ];

        // Define the custom error messages
        $messages = [
            'username.required' => 'The username field is mandatory.',
            'username.string' => 'The username must be a string.',
            'password.required' => 'The password field is mandatory.',
            'password.string' => 'The password must be a string.',
        ];

        // Validate the request with custom messages
        $credentials = $request->validate($rules, $messages);

        // Check if the username exists
        $user = User::where('username', $request->username)->first();
        if (!$user) {
            throw ValidationException::withMessages([
                'username' => 'The provided username does not exist.',
            ]);
        }

        // Check if the password is correct
        if (!Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'password' => 'The provided password is incorrect.',
            ]);
        }

        // Attempt to log in the user
        if (!Auth::attempt($credentials, $request->boolean('remember'))) {
            throw ValidationException::withMessages([
                'username' => __('auth.failed'),
            ]);
        }

        // end

        $request->authenticate();

        $request->session()->regenerate();

        $notification = array(
            'message' => 'User Login Successfully',
            'alert-type' => 'success'
        );

        return redirect()->intended(RouteServiceProvider::HOME)->with($notification);
    }

    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
