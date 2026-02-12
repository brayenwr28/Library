<?php

namespace App\Http\Middleware;

use App\Models\Admin;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureAdminAccount
{
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();

        if (! $user) {
            return redirect()->route('admin.login');
        }

        $isAdmin = Admin::where('email', $user->email)->exists();

        if (! $isAdmin) {
            Auth::logout();

            return redirect()
                ->route('admin.login')
                ->withErrors(['email' => 'Akses terbatas untuk admin.']);
        }

        return $next($request);
    }
}
