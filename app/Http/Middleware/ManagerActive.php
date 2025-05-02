<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class ManagerActive
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $manager = Auth::guard('manager')->user();
        
        if (!$manager || !$manager->is_active) { // Assuming you have an is_active column
            Auth::guard('manager')->logout();
            return redirect()->route('manager.login')->with('error', 'Your account is not active.');
        }

        return $next($request);
    }
}