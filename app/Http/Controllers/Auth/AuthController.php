<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        // Render the single combined auth view (login/register tabs)
        // return view('auth');
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            switch ($user->user_type) {
                case 'superadmin':
                    return redirect()->route('superadmin.mountains.index');
                case 'admin':
                    return redirect()->route('dashboard.index');
                case 'pendaki':
                    return redirect()->route('pendaki.dashboard');
                default:
                    Auth::logout();
                    return redirect()->back()->withErrors(['email' => 'Role tidak valid.']);
            }
        }

        return redirect()->back()->withErrors(['email' => 'Email atau password salah.']);
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'string', 'min:6'],
            'phone' => ['required', 'string', 'min:6'],
            'user_type' => ['required', 'in:superadmin,admin,pendaki'],
        ]);

        // Create user via Eloquent to get a User model instance for Auth::login
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        // Optional fields if available in schema
        if ($request->filled('phone')) {
            $user->phone = $request->phone;
        }
        if ($request->filled('user_type')) {
            $user->user_type = $request->user_type;
        }
        $user->save();

        Auth::login($user);

        return redirect('/profile');
    }

    public function logout()
    {
        Auth::logout();
        Session::flush();
        return redirect('/login');
    }
}
