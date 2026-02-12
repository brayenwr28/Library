<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function loginStore(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
        
        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            return redirect()->route('dashboard');
        }

        return back()
            ->withErrors([
                'email' => 'Email atau kata sandi tidak cocok.',
            ])
            ->onlyInput('email');
    }

    public function register()
    {
        return view('auth.register');
    }

    public function registerStore(Request $request)
    {
        $validated = $request->validate([
            'username' => ['required', 'string', 'max:255', 'unique:members,username'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:members,email', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'nim' => ['required', 'string', 'max:20', 'unique:members,nim'],
            'prodi' => ['required', 'string', 'max:100'],
            'tgl_daftar' => ['nullable', 'date'],
        ]);

        $registrationDate = isset($validated['tgl_daftar'])
            ? Carbon::parse($validated['tgl_daftar'])
            : now();

        $year = $registrationDate->format('Y');
        $sequence = Member::whereYear('tgl_daftar', $year)->count() + 1;
        $memberId = sprintf('PUS%s-%04d', $year, $sequence);

        $hashedPassword = Hash::make($validated['password']);

        DB::transaction(function () use ($validated, $memberId, $registrationDate, $hashedPassword) {
            User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => $hashedPassword,
            ]);

            Member::create([
                'username' => $validated['username'],
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => $hashedPassword,
                'nim' => $validated['nim'] ?? null,
                'prodi' => $validated['prodi'] ?? null,
                'member_id' => $memberId,
                'tgl_daftar' => $registrationDate,
            ]);
        });

        return redirect()
            ->route('login')
            ->with('status', 'Registrasi berhasil, silakan login.');
    }
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('dashboard');
    }
}
