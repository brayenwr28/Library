<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Book;
use App\Models\Perpuss;
use App\Models\Member;
use App\Models\Peminjaman;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class AdminRegistrationController extends Controller
{
    public function index(): View
    {
        $totalBooks = Book::count();
        $totalDigitalBooks = Perpuss::whereNotNull('cover_path')->count();
        $totalLibraryBooks = Book::whereNull('pdf_path')->count();
        $totalRegisteredUsers = Member::count();

        $period = CarbonPeriod::create(Carbon::now()->subDays(29), Carbon::now());
        $borrowTotals = Peminjaman::selectRaw('DATE(COALESCE(tgl_pinjam, created_at)) as tanggal, COUNT(*) as total')
            ->whereDate('created_at', '>=', Carbon::now()->subDays(29))
            ->groupBy('tanggal')
            ->orderBy('tanggal')
            ->pluck('total', 'tanggal');

        $borrowChartLabels = [];
        $borrowChartData = [];

        foreach ($period as $date) {
            $label = $date->translatedFormat('d M');
            $borrowChartLabels[] = $label;
            $borrowChartData[] = $borrowTotals[$date->toDateString()] ?? 0;
        }

        $recentActivities = Peminjaman::with(['book:id,title', 'member:id,name'])
            ->latest('created_at')
            ->take(5)
            ->get()
            ->map(function (Peminjaman $entry) {
                return [
                    'icon' => $entry->status === 'dikembalikan' ? 'fas fa-undo' : 'fas fa-book',
                    'context' => $entry->status === 'dikembalikan' ? 'bg-success-subtle text-success' : 'bg-primary-subtle text-primary',
                    'title' => $entry->book?->title ?? $entry->judul_buku ?? 'Peminjaman buku',
                    'description' => $entry->member?->name ? 'Oleh ' . $entry->member->name : 'Aktivitas peminjaman terbaru',
                    'time' => $entry->created_at->diffForHumans(),
                ];
            })
            ->toArray();

        return view('admin.dashboard.dashboard', compact(
            'totalBooks',
            'totalDigitalBooks',
            'totalLibraryBooks',
            'totalRegisteredUsers',
            'borrowChartLabels',
            'borrowChartData',
            'recentActivities'
        ));
    }
    public function login(): View
    {
        return view('auth.loginAdm');
    }

    public function loginStore(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        $remember = $request->boolean('remember');

        if (! Auth::guard('admin')->attempt($credentials, $remember)) {
            return back()
                ->withErrors(['email' => 'Email atau kata sandi tidak valid.'])
                ->onlyInput('email');
        }

        $request->session()->regenerate();

        return redirect()->intended(route('admin.dashboard'));
    }

    public function create(): View
    {
        return view('auth.registeradm', [
            'action' => route('admin.register.store'),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email', 'unique:admins,email'],
            'username' => ['required', 'string', 'max:255', 'unique:admins,username'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $admin = Admin::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'username' => $validated['username'],
            'password' => Hash::make($validated['password']),
        ]);

        Auth::guard('admin')->login($admin);

        return redirect()
            ->route('admin.dashboard')
            ->with('status', 'Registrasi admin berhasil. Selamat datang!');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::guard('admin')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }
}
