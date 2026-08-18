<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Book;
use App\Models\Perpuss;
use App\Models\Member;
use App\Models\Peminjaman;
use App\Models\Pengembalian;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Validation\Rule;

class AdminRegistrationController extends Controller
{
    public function index(Request $request): View
    {
        $selectedPeriod = (int) $request->query('period', 30);
        $allowedPeriods = [1, 7, 30, 365];

        if (! in_array($selectedPeriod, $allowedPeriods, true)) {
            $selectedPeriod = 30;
        }

        $startDate = $selectedPeriod === 365
            ? Carbon::now()->startOfYear()
            : Carbon::now()->subDays(max($selectedPeriod - 1, 0))->startOfDay();
        $endDate = Carbon::now()->endOfDay();

        $periodLabel = match ($selectedPeriod) {
            1 => 'Hari Ini',
            7 => '7 Hari Terakhir',
            365 => 'Tahun Berjalan',
            default => '30 Hari Terakhir',
        };

        $totalDigitalBooks = Book::sum('stock');
        $totalLibraryBooks = Perpuss::sum('stock');
        $totalBooks = $totalDigitalBooks + $totalLibraryBooks;
        $totalRegisteredUsers = Member::count();

        // Pending Confirmations
        $pendingPeminjaman = Peminjaman::where('status', 'menunggu_konfirmasi')->count();
        $pendingPeminjamanItems = Peminjaman::with(['member:id,name,email'])
            ->where('status', 'menunggu_konfirmasi')
            ->latest('created_at')
            ->take(5)
            ->get();
        $pendingPengembalian = Pengembalian::where('status', 'menunggu_konfirmasi')->count();
        $totalDendaHariIni = Pengembalian::whereDate('created_at', today())
            ->where('status', 'diterima')
            ->sum('denda');

        $period = CarbonPeriod::create($startDate, $endDate);
        $borrowTotals = Peminjaman::selectRaw('DATE(COALESCE(tgl_pinjam, created_at)) as tanggal, COUNT(*) as total')
            ->whereBetween('created_at', [$startDate, $endDate])
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
            'recentActivities',
            'pendingPeminjaman',
            'pendingPeminjamanItems',
            'pendingPengembalian',
            'totalDendaHariIni',
            'selectedPeriod',
            'periodLabel'
        ));
    }
    public function login(Request $request): RedirectResponse
    {
        return redirect()->route('login');
    }

    public function loginStore(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $remember = $request->boolean('remember');

        // 1. Cek Admin
        $admin = Admin::where('email', $credentials['email'])->first();
        if ($admin) {
            $passwordMatches = Hash::check($credentials['password'], $admin->password) ||
                hash_equals((string) $admin->password, (string) $credentials['password']);

            if ($passwordMatches) {
                if (! Hash::check($credentials['password'], $admin->password)) {
                    $admin->forceFill([
                        'password' => Hash::make($credentials['password']),
                    ])->save();
                }
                Auth::guard('admin')->login($admin, $remember);
                $request->session()->regenerate();
                return redirect()->intended(route('admin.dashboard'));
            }
        }

        // 2. Cek Member
        $member = Member::where('email', $credentials['email'])->first();
        if ($member) {
            $memberPasswordMatches = Hash::check($credentials['password'], $member->password) ||
                ($member->password === $credentials['password']);

            if ($memberPasswordMatches) {
                if (! Hash::check($credentials['password'], $member->password)) {
                    $member->update(['password' => Hash::make($credentials['password'])]);
                }
                Auth::login($member, $remember);
                $request->session()->regenerate();
                return redirect()->intended(route('dashboard'));
            }
        }

        return back()
            ->withErrors(['email' => 'Email atau kata sandi tidak valid.'])
            ->onlyInput('email');
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
            'password' => Hash::make($validated['password'])
        ]);

        return redirect()
            ->route('login')
            ->with('status', 'Registrasi Admin berhasil! Silakan login dengan akun Anda.');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::guard('admin')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }

    /**
     * Return chart data for a given period as JSON (AJAX).
     */
    public function chartData(Request $request)
    {
        $selectedPeriod = (int) $request->query('period', 30);
        $allowedPeriods = [1, 7, 30, 365];

        if (! in_array($selectedPeriod, $allowedPeriods, true)) {
            $selectedPeriod = 30;
        }

        $startDate = $selectedPeriod === 365
            ? Carbon::now()->startOfYear()
            : Carbon::now()->subDays(max($selectedPeriod - 1, 0))->startOfDay();
        $endDate = Carbon::now()->endOfDay();

        $period = CarbonPeriod::create($startDate, $endDate);

        $borrowTotals = Peminjaman::selectRaw('DATE(COALESCE(tgl_pinjam, created_at)) as tanggal, COUNT(*) as total')
            ->whereBetween('created_at', [$startDate, $endDate])
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

        return response()->json([
            'labels' => $borrowChartLabels,
            'totals' => $borrowChartData,
        ]);
    }

    public function profileEdit(Request $request): View
    {
        $admin = Auth::guard('admin')->user();

        return view('admin.profile.edit', [
            'admin' => $admin,
        ]);
    }

    public function profileUpdate(Request $request): RedirectResponse
    {
        $admin = Auth::guard('admin')->user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => [
                'required', 'string', 'max:255',
                Rule::unique('admins', 'username')->ignore($admin->id),
            ],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ]);

        $admin->name = $validated['name'];
        $admin->username = $validated['username'];

        if (! empty($validated['password'])) {
            $admin->password = Hash::make($validated['password']);
        }

        $admin->save();

        return redirect()->route('admin.profile.edit')->with('status', 'Profil admin berhasil diperbarui.');
    }
}
