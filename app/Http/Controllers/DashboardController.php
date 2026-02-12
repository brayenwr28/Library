<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Member;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard.welcome');
    }

    public function contact(Request $request)
    {
        return view('dashboard.contact');
    }
    public function katalog(Request $request)
    {
        $books = Book::orderByDesc('created_at')->get();

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
