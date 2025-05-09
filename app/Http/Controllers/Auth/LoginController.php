<?php

namespace App\Http\Controllers\Auth;

use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        if (Auth::check()) {
            return $this->redirectTo(Auth::user());
        }
        return view('auth.login');
    }

    public function login(Request $request)
{
    $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required'],
    ]);
    // remember me
    $credentials = $request->only('email', 'password');
    $remember = true;

    // check that the user isn't deleted
    $user = User::where('email', $credentials['email'])->first();
    if ($user && $user->trashed()) {
        return back()->with('error', 'Tu cuenta ha sido desactivada. Contacta al administrador.');
    }

    // Check if the user is already authenticated
    if (Auth::check()) {
        return $this->redirectTo(Auth::user());
    }

    if (Auth::attempt($credentials, $remember)) {
        $request->session()->regenerate();
        $user = Auth::user();
        // dd($user);
        return $this->redirectTo($user);
    }

    return back()->with('error', 'Las credenciales no son válidas');
}

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('welcome');
    }

    public function redirectTo($user){

        switch ($user->role) {
            case UserRole::ADMIN:
                return redirect()->route('admin.panel');
            case UserRole::PROFESOR:
                return redirect()->route('profesor.home');
            case UserRole::PADRE:
                return redirect()->route('padre.home');
            default:
                Auth::logout();
                return redirect()->route('login')->with('error', 'Rol no autorizado');
        }
    }

}
