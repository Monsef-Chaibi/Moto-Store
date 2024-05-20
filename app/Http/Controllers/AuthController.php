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
            // Check if logged in user is an admin
            if (Auth::user()->is_admin) {
                session()->flash('success', 'Welcome back, Admin!');
                return redirect('/');  // Redirect to the admin dashboard
            } else {
                session()->flash('success', 'Successfully logged in!');
                return redirect('/');  // Redirect to the regular user homepage
            }
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

            // Check if email already exists
            $existingUser = User::where('email', $user->email)->first();

            if ($existingUser) {
                // If google_id is not set, update it
                if (empty($existingUser->google_id)) {
                    $existingUser->update([
                        'google_id' => $user->id,
                        'name' => $user->name,  // Optionally update other fields
                    ]);
                }

                // Login the user
                Auth::login($existingUser);

                // Check if user is an admin
                if (Auth::user()->is_admin) {
                    session()->flash('success', 'Welcome back, Admin!');
                    return redirect('/');  // Redirect to admin dashboard
                } else {
                    session()->flash('success', 'Successfully logged in!');
                    return redirect('/');  // Redirect to homepage
                }
            } else {
                // Create a new user
                $newUser = User::create([
                    'name' => $user->name,
                    'email' => $user->email,
                    'google_id' => $user->id,
                    'password' => encrypt('google')  // Use a secure random password
                ]);
                Auth::login($newUser);
                session()->flash('success', 'Successfully registered and logged in!');
                return redirect('/');  // Redirect to homepage
            }
        } catch (Exception $e) {
            session()->flash('error', 'There was a problem logging in with Google :' . $e->getMessage());
            return redirect('login')->withErrors(['error' => $e->getMessage()]);
        }
    }


}

