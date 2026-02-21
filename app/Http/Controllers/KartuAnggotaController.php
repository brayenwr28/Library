<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Support\Facades\Auth;
use PDF;

class KartuAnggotaController extends Controller
{
    public function index()
    {
        $member = Member::where('email', Auth::user()->email)->first();
        
        if (!$member) {
            return redirect()->route('dashboard')->with('error', 'Data member tidak ditemukan');
        }

        return view('KartuAnggota.index', ['member' => $member]);
    }

    public function downloadPDF()
    {
        $member = Member::where('email', Auth::user()->email)->first();
        
        if (!$member) {
            return redirect()->route('dashboard')->with('error', 'Data member tidak ditemukan');
        }

        $pdf = PDF::loadView('KartuAnggota.pdf', ['member' => $member]);
        return $pdf->download('KTM_' . $member->member_id . '.pdf');
    }

    public function show($member_id)
    {
        $member = Member::where('member_id', $member_id)->first();
        
        if (!$member) {
            return redirect()->route('dashboard')->with('error', 'Data member tidak ditemukan');
        }

        return view('KartuAnggota.show', ['member' => $member]);
    }
}
