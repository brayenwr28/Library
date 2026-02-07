<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Http\Requests\SignatureStampRequest;

class SignatureStampController extends Controller
{
    // Form untuk upload signature dan stamp
    public function form()
    {
        $member = Member::first();
        return view('admin.signature-stamp-form', compact('member'));
    }

    // Upload signature dan stamp
    public function upload(SignatureStampRequest $request)
    {
        $member = Member::first() ?? new Member();

        // Upload signature
        if ($request->hasFile('signature')) {
            if ($member->signature_path && file_exists(storage_path('app/' . $member->signature_path))) {
                unlink(storage_path('app/' . $member->signature_path));
            }
            $signaturePath = $request->file('signature')->store('signatures', 'public');
            $member->signature_path = $signaturePath;
        }

        // Upload stamp
        if ($request->hasFile('stamp')) {
            if ($member->stamp_path && file_exists(storage_path('app/' . $member->stamp_path))) {
                unlink(storage_path('app/' . $member->stamp_path));
            }
            $stampPath = $request->file('stamp')->store('stamps', 'public');
            $member->stamp_path = $stampPath;
        }

        if ($member->id === null) {
            $member->username = 'admin';
            $member->name = 'Administrator';
            $member->email = 'admin@perpus.local';
            $member->password = bcrypt('admin');
            $member->nim = '00000';
            $member->prodi = 'Administrator';
            $member->member_id = 'ADMIN001';
            $member->tgl_daftar = now();
        }

        $member->save();

        return redirect()->back()->with('success', 'Tanda tangan dan stempel berhasil diupload!');
    }
}
