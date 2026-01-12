<?php

declare(strict_types=1);

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;
use Inertia\Response;

final class PasswordChangeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    /**
     * Show the login page.
     */
    public function create(Request $request): Response
    {
        return Inertia::render('auth/ChangePassword', [
            'email' => $request->email,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        DB::transaction(function () use ($request) {
            $user = User::where('email', $request->email)->firstOrFail();

            $user->forceFill([
                'change_password' => true,
                'password' => Hash::make($request->password),
            ])->save();

            event(new PasswordReset($user));
        });

        return to_route('login')->with('status', 'Mot de passe changé avec succès.');
    }
}
