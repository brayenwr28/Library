<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Member;
use App\Models\Peminjaman;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $member = null;
        $activeLoans = collect();
        $dueSoonLoans = collect();
        $overdueLoans = collect();
        $nearestLoan = null;
        $nearestLoanDaysRemaining = null;
        $fineStatusLabel = 'Aman';
        $fineStatusClass = 'bg-emerald-100 text-emerald-700';
        $estimatedFine = 0;

        if (Auth::check()) {
            $member = Member::where('email', Auth::user()->email)->first();

            if ($member) {
                $activeLoans = Peminjaman::where('member_id', $member->id)
                    ->where('status', 'diambil')
                    ->orderBy('tgl_kembali')
                    ->get();

                $today = now()->startOfDay();

                $dueSoonLoans = $activeLoans->filter(function (Peminjaman $loan) use ($today) {
                    $dueDate = Carbon::parse($loan->tgl_kembali)->startOfDay();
                    return $dueDate->greaterThanOrEqualTo($today) && $dueDate->diffInDays($today) <= 3;
                })->values();

                $overdueLoans = $activeLoans->filter(function (Peminjaman $loan) use ($today, &$estimatedFine) {
                    $dueDate = Carbon::parse($loan->tgl_kembali)->startOfDay();

                    if ($dueDate->lessThan($today)) {
                        $daysLate = $today->diffInDays($dueDate);
                        $weeksLate = (int) ceil($daysLate / 7);
                        $estimatedFine += $weeksLate * 5000;
                        return true;
                    }

                    return false;
                })->values();

                $nearestLoan = $activeLoans->first();

                if ($nearestLoan) {
                    $dueDate = Carbon::parse($nearestLoan->tgl_kembali)->startOfDay();
                    if ($dueDate->greaterThanOrEqualTo($today)) {
                        $nearestLoanDaysRemaining = $today->diffInDays($dueDate);
                    } else {
                        $nearestLoanDaysRemaining = -$dueDate->diffInDays($today);
                    }
                }

                if ($overdueLoans->isNotEmpty()) {
                    $fineStatusLabel = 'Terlambat';
                    $fineStatusClass = 'bg-red-100 text-red-700';
                } elseif ($dueSoonLoans->isNotEmpty()) {
                    $fineStatusLabel = 'Perlu perhatian';
                    $fineStatusClass = 'bg-amber-100 text-amber-700';
                }
            }
        }

        return view('dashboard.welcome', [
            'member' => $member,
            'activeLoans' => $activeLoans,
            'dueSoonLoans' => $dueSoonLoans,
            'overdueLoans' => $overdueLoans,
            'nearestLoan' => $nearestLoan,
            'nearestLoanDaysRemaining' => $nearestLoanDaysRemaining,
            'fineStatusLabel' => $fineStatusLabel,
            'fineStatusClass' => $fineStatusClass,
            'estimatedFine' => $estimatedFine,
        ]);
    }

    public function contact(Request $request)
    {
        return view('dashboard.contact');
    }
    public function katalog(Request $request)
    {
        $search = trim((string) $request->query('q', $request->query('search', '')));

        $books = Book::query()
            ->when($search !== '', function ($query) use ($search) {
                $like = "%{$search}%";
                $query->where(function ($inner) use ($like) {
                    $inner->where('title', 'like', $like)
                        ->orWhere('author', 'like', $like)
                        ->orWhere('publisher', 'like', $like)
                        ->orWhere('isbn', 'like', $like)
                        ->orWhere('category', 'like', $like)
                        ->orWhere('publication_year', 'like', $like)
                        ->orWhere('summary', 'like', $like);
                });
            })
            ->orderByDesc('created_at')
            ->get();

        $borrowedBookIds = [];

        if (Auth::check()) {
            $member = Member::where('email', Auth::user()->email)->first();

            if ($member) {
                $borrowedBookIds = Peminjaman::where('member_id', $member->id)
                    ->whereNotNull('book_id')
                    ->where('status', 'diambil')
                    ->pluck('book_id')
                    ->unique()
                    ->values()
                    ->all();
            }
        }

        return view('dashboard.katalog', [
            'books' => $books,
            'search' => $search,
            'borrowedBookIds' => $borrowedBookIds,
        ]);
    }
    public function sejarah(Request $request)
    {
        return view('dashboard.sejarah');
    }
    public function tentang(Request $request)
    {
        return view('dashboard.tentang');
    }
}
