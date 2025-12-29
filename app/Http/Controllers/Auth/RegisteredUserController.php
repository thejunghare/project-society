<?php

namespace App\Http\Controllers\Auth;

use App\Events\UserRegisteredAsRoleIdTwo;
use App\Models\User;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Events\UserRegistered;
use Illuminate\Validation\Rules;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Auth\Events\Registered;
use App\Providers\RouteServiceProvider;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'phone' => [
                'required',
                'string',
                'regex:/^[6-9]\d{9}$/',
                'unique:users,phone',
                'max:255',
                'lowercase',
            ],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'role_id' => 3,
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));
        event(new UserRegisteredAsRoleIdTwo($user)); // adding entry for the accountant table if role_id = 2

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}
