<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    //
    public function __invoke()
    {
        return \view('auth.login');
    }

    public function acceder(Request $request)
    {
        $request->validate([
            'nombre' => 'required|min:3',
            'password' => 'required',
        ]);

        if ($request->recuerdame != '') {
            $recordar = true;
        } else{
            $recordar = false;
        }

        if (\auth()->attempt($request->only(['nombre', 'password']), $recordar)) {
            $request->session()->regenerate();

            return \redirect()->route('dashboard');
        }

        return \redirect()->back()->withErrors(['nombre' => 'Usuario o contraseña incorrectos']);
    }

    public function logout(Request $request) {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return \redirect()->route('login');
    }

}
