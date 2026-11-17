<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use Spatie\Permission\Models\Role;

class AuthController extends Controller
{
    public function showLogin(): View|RedirectResponse
    {
        if (Auth::check()) {
            return redirect()->route('home');
        }

        return view('auth.login');
    }

    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            /** @var User $user */
            $user = Auth::user();
            if ($user->hasRole('admin')) {
                return redirect()->intended(route('admin.dashboard'))
                    ->with('success', 'স্বাগতম অ্যাডমিন! আপনি সফলভাবে লগইন করেছেন।');
            }

            return redirect()->intended(route('home'))
                ->with('success', 'স্বাগতম, '.$user->name.'! আপনি সফলভাবে লগইন করেছেন।');
        }

        return back()->withErrors([
            'email' => 'আপনার দেওয়া ইমেইল অথবা পাসওয়ার্ডটি সঠিক নয়।',
        ])->onlyInput('email');
    }

    public function showRegister(): View|RedirectResponse
    {
        if (Auth::check()) {
            return redirect()->route('home');
        }

        return view('auth.register');
    }

    public function register(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => ['required', 'string', 'max:20'],
            'role' => ['required', 'in:seller,buyer'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'password' => Hash::make($validated['password']),
        ]);

        $role = Role::firstOrCreate(['name' => $validated['role']]);
        $user->assignRole($role);

        Auth::login($user);

        return redirect()->route('home')->with('success', 'আপনার অ্যাকাউন্ট সফলভাবে তৈরি হয়েছে!');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')->with('success', 'আপনি সফলভাবে লগআউট হয়েছেন।');
    }
}
