<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laracasts\Flash\Flash;
class AuthController extends Controller
{
    public function register(Request $request)
    {
        // Validate input with specific error messages
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ], [
            'email.unique' => 'This email is already registered.',
            'password.min' => 'Password must be at least 8 characters.',
        ]);

        // Check if the validation fails
        if ($validator->fails()) {
            // Determine which error to flash
            if ($validator->errors()->has('email')) {
                session()->flash('error', $validator->errors()->first('email'));
            } elseif ($validator->errors()->has('password')) {
                session()->flash('error', $validator->errors()->first('password'));
            }

            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Create user if validation succeeds
        $user = User::create([
            'name' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Log the user in
        auth()->login($user);

        // Flash success message
        session()->flash('success', 'Successfully registered!');
        return redirect()->to('/'); // Redirect to homepage or other desired location
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            session()->flash('success', 'Successfully logged in!');
            return redirect('/');
        }

        session()->flash('error', 'The provided credentials do not match our records.');
        return back()->withErrors([

            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }
    public function logout()
    {
        Auth::logout();

        // Redirect to homepage or login page
        return redirect('/login')->with('status', 'You have been successfully logged out!');
    }

    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $user = Socialite::driver('google')->user();

            // Find existing user or create a new one
            $finduser = User::where('google_id', $user->id)->first();
            if ($finduser) {
                Auth::login($finduser);
            } else {
                $newUser = User::create([
                    'name' => $user->name,
                    'email' => $user->email,
                    'google_id'=> $user->id,
                    'password' => encrypt('google')  // You can generate random string
                ]);
                Auth::login($newUser);
            }

            return redirect('/'); // Redirect to the intended page
        } catch (Exception $e) {
            dd($e->getMessage());
            return redirect('login')->withError($e->getMessage());
        }
    }
}

