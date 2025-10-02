<?php

namespace App\Http\Controllers\Web\Dashboard\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class PasswordResetController extends Controller
{


    /**
     * Show forgot password form
     */
    public function showForgotPasswordForm()
    {
        return view('dashboard.auth.forgot-password');
    }

    /**
     * Send password reset link email
     */
    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email|exists:users,email']);

        $user = User::where('email', $request->email)->first();

        if ($user) {
            // Generate reset token
            $token = Str::random(64);
            $expiresAt = now()->addMinutes(60);

            // Store token in database
            DB::table('password_reset_tokens')->updateOrInsert(
                ['email' => $user->email],
                [
                    'email' => $user->email,
                    'token' => Hash::make($token),
                    'created_at' => now()
                ]
            );

            // Send email
            $resetUrl = route('reset-password', ['token' => $token]);

            Mail::send('emails.password-reset', ['resetUrl' => $resetUrl], function ($message) use ($user) {
                $message->to($user->email)
                    ->subject('Password Reset Request');
            });

            return redirect()->route('login')->with('success', 'Password reset link sent to your email');
        }

        return back()->withErrors(['email' => 'We can\'t find a user with that email address.']);
    }

    /**
     * Show reset password form
     */
    public function showResetPasswordForm($token)
    {
        return view('dashboard.auth.reset-password', compact('token'));
    }

    /**
     * Reset user password
     */
    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email|exists:users,email',
            'password' => 'required|min:8|confirmed',
        ]);

        $passwordReset = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->first();

        if (!$passwordReset || !Hash::check($request->token, $passwordReset->token)) {
            return back()->withErrors(['token' => 'Invalid or expired reset token.']);
        }

        // Check if token is not expired (1 hour)
        if (now()->diffInMinutes($passwordReset->created_at) > 60) {
            return back()->withErrors(['token' => 'Reset token has expired.']);
        }

        // Update user password
        User::where('email', $request->email)->update([
            'password' => Hash::make($request->password)
        ]);

        // Delete the used token
        DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        return redirect()->route('login')->with('success', 'Your password has been reset successfully!');
    }
}
