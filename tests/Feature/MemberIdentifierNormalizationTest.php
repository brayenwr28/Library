<?php

namespace Tests\Feature;

use App\Models\Member;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MemberIdentifierNormalizationTest extends TestCase
{
    use RefreshDatabase;

    public function test_nim_and_nik_are_normalized_when_saved(): void
    {
        $member = Member::create([
            'username' => 'memberquote001',
            'name' => 'Test Quote User',
            'email' => 'memberquote001@example.com',
            'password' => bcrypt('password123'),
            'nim' => "'235520211002'",
            'nik' => '"1234567890123456"',
            'prodi' => 'Teknik Informatika',
            'member_id' => 'PUS2026-0001',
            'tgl_daftar' => '2026-09-23',
        ]);

        $this->assertSame('235520211002', $member->fresh()->nim);
        $this->assertSame('1234567890123456', $member->fresh()->nik);
    }
}
