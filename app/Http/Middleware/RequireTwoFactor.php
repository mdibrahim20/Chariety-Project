<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RequireTwoFactor
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (!$user) {
            return redirect()->route('admin.login');
        }

        // Check if user has 2FA enabled
        if ($user->hasTwoFactorEnabled()) {
            // Check if 2FA is verified in this session
            if (!session('two_factor_verified')) {
                return redirect()->route('admin.two-factor.verify');
            }
        }

        // If user is required to have 2FA but hasn't set it up
        if ($user->two_factor_required && !$user->hasTwoFactorEnabled()) {
            return redirect()->route('admin.two-factor.setup')
                ->with('warning', 'You are required to set up two-factor authentication.');
        }

        return $next($request);
    }
}
