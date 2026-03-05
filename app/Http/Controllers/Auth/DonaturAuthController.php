<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class DonaturAuthController extends Controller
{
    /**
     * Display the donatur registration form.
     */
    public function showRegisterForm(): View
    {
        return view('auth.donatur-register');
    }

    /**
     * Handle donatur registration.
     */
    public function register(Request $request): RedirectResponse
    {
        $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'no_hp' => ['nullable', 'string', 'max:20'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'no_hp' => $request->no_hp,
            'password' => Hash::make($request->password),
            'role' => 'donatur',
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect()->route('donatur.dashboard');
    }

    /**
     * Display the donatur login form.
     */
    public function showLoginForm(Request $request): View
    {
        // Store redirect URL in session if provided (e.g. from donation choice page)
        if ($request->has('redirect')) {
            session(['url.intended' => $request->query('redirect')]);
        }

        return view('auth.donatur-login');
    }

    /**
     * Handle login for all roles.
     */
    public function login(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (!Auth::attempt($request->only('email', 'password'), $request->boolean('remember'))) {
            return back()->withErrors([
                'email' => 'Email atau password salah.',
            ])->onlyInput('email');
        }

        $request->session()->regenerate();

        $user = Auth::user();

        // Redirect based on role
        if ($user->isAdmin()) {
            return redirect()->intended(route('admin.dashboard'));
        }

        if ($user->isDonatur()) {
            return redirect()->intended(route('donatur.dashboard'));
        }

        return redirect()->intended(route('user.dashboard'));
    }

    /**
     * Logout donatur.
     */
    public function logout(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}
