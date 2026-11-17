<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! Auth::check() || ! Auth::user()->hasRole('admin')) {
            abort(403, 'অননুমোদিত অ্যাক্সেস। এই পৃষ্ঠাটি কেবল অ্যাডমিনদের জন্য সংরক্ষিত।');
        }

        return $next($request);
    }
}
