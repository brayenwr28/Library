<?php

namespace App\Http\Controllers\Auth;

use App\Models\Member;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Hash;

class LoginController
{
    public function create()
    {
        return view('auth.login-member');
    }

    public function store(LoginRequest $request)
    {
        $credentials = $request->validated();

        // Coba login dengan username & password dari Member
        $member = Member::where('username', $credentials['username'])->first();

        if ($member && Hash::check($credentials['password'], $member->password)) {
            // Login berhasil, set session
            session(['member_id' => $member->id, 'member' => $member]);
            return redirect()->route('peminjaman.index')->with('success', 'Login berhasil!');
        }

        // Login gagal
        return back()->withErrors([
            'username' => 'Username atau password salah.',
        ])->onlyInput('username');
    }

    public function logout()
    {
        session()->forget(['member_id', 'member']);
        return redirect('/')->with('success', 'Logout berhasil!');
    }
}
