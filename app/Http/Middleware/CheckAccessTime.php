<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckAccessTime
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $now = Carbon::now();
        $start = Carbon::createFromTime(7, 0);
        $end = Carbon::createFromTime(17, 0);
        if ($now->lessThan($start) || $now->greaterThan($end)) {
            return response('Ngoài giờ truy cập', 403);
        }
        return $next($request);
    }
}
