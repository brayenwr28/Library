<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

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
        
        $remember = $request->boolean('remember');

        // 1. Cek Kredensial Admin
        $admin = \App\Models\Admin::where('email', $credentials['email'])->first();
        if ($admin) {
            $adminPasswordMatches = \Illuminate\Support\Facades\Hash::check($credentials['password'], $admin->password) ||
                hash_equals((string) $admin->password, (string) $credentials['password']);

            if ($adminPasswordMatches) {
                if (! \Illuminate\Support\Facades\Hash::check($credentials['password'], $admin->password)) {
                    $admin->forceFill([
                        'password' => \Illuminate\Support\Facades\Hash::make($credentials['password']),
                    ])->save();
                }
                Auth::guard('admin')->login($admin, $remember);
                $request->session()->regenerate();
                return redirect()->intended(route('admin.dashboard'));
            }
        }

        // 2. Cek Kredensial Member/User
        $member = Member::where('email', $credentials['email'])->first();
        if ($member) {
            $memberPasswordMatches = \Illuminate\Support\Facades\Hash::check($credentials['password'], $member->password) ||
                ($member->password === $credentials['password']);

            if ($memberPasswordMatches) {
                if (! \Illuminate\Support\Facades\Hash::check($credentials['password'], $member->password)) {
                    $member->update(['password' => \Illuminate\Support\Facades\Hash::make($credentials['password'])]);
                }
                Auth::login($member, $remember);
                $request->session()->regenerate();
                return redirect()->intended(route('dashboard'));
            }
        }

        // 3. Gagal jika tidak cocok
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
            'password' => ['required', 'string', 'confirmed'],
            'nim' => ['required', 'string', 'max:20', 'unique:members,nim'],
            'prodi' => ['required', 'string', 'max:100'],
            'jenis_anggota' => ['required', 'in:mahasiswa,dosen'],
            'tgl_daftar' => ['nullable', 'date'],
        ]);

        $registrationDate = isset($validated['tgl_daftar'])
            ? Carbon::parse($validated['tgl_daftar'])
            : now();

        $year = $registrationDate->format('Y');
        $sequence = Member::whereYear('tgl_daftar', $year)->count() + 1;
        $memberId = sprintf('PUS%s-%04d', $year, $sequence);

        DB::transaction(function () use ($validated, $memberId, $registrationDate) {
            Member::create([
                'username' => $validated['username'],
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => \Illuminate\Support\Facades\Hash::make($validated['password']),
                'nim' => $validated['nim'] ?? null,
                'prodi' => $validated['prodi'] ?? null,
                'jenis_anggota' => $validated['jenis_anggota'],
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