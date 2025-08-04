<?php

namespace App\Http\Controllers\Auth;

use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Validation\ValidationException;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    // public function store(LoginRequest $request): RedirectResponse
    // {
    //     $request->authenticate();

    //        $user = Auth::user();
    //         if (!$user->is_active) {
    //         Auth::logout();
    //         throw ValidationException::withMessages([
    //             'email' => __('Your account is inactive. Please contact the administrator.'),
    //         ]);
    //     }

    //     $request->session()->regenerate();

    //     return redirect()->intended(route('dashboard', absolute: false));
    // }

    public function store(LoginRequest $request): RedirectResponse
    {
        // Attempt to authenticate the user
        $request->authenticate();

        // Retrieve the authenticated user
        $user = Auth::user();

        // Check if the user is inactive
        if (!$user || !$user->is_active) {
            Auth::logout();

            throw ValidationException::withMessages([
                'email' => __('Your account is inactive. Please contact the administrator.'),
            ]);
        }

        // Regenerate session to prevent fixation attacks
        $request->session()->regenerate();

        // Redirect to intended route
        return redirect()->intended(route('dashboard', absolute: false));
    }


    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
