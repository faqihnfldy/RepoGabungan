<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    public function showRegisterForm()
    {
        if (Auth::check()) {
            // Redirect based on role if already logged in
            $user = Auth::user();
            if ($user->role === 'admin') {
                return redirect()->route('admin.dashboard');
            } elseif ($user->role === 'doctor') {
                return redirect()->route('doctor.dashboard');
            } elseif ($user->role === 'user') {
                return redirect()->route('pasien.dashboard');
            }
        }
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role' => ['required', 'in:user,admin,doctor'], // Validasi role
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role, // menyimpan role yang dipilih
        ]);

        Auth::login($user);

        $request->session()->regenerate();

        // Redirect based on role
        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard')->with('success', 'Registrasi berhasil! Anda telah login sebagai Admin.');
        }
        elseif ($user->role === 'user') {
            return redirect()->route('pasien.dashboard')->with('success', 'Registrasi berhasil! Anda login sebagai Pasien.');
        } 
        elseif ($user->role === 'doctor') {
            return redirect()->route('doctor.dashboard')->with('success', 'Registrasi berhasil! Anda login sebagai Dokter.');
        }

        // Fallback redirect (in case role is not user, though unlikely)
        return redirect()->route('home')->with('success', 'Registrasi berhasil!');
    }
}