<?php

namespace App\Http\Middleware;

use App\Models\Option;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RegisterMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $can_register = Option::where('name', 'can-register')->first();
        if($can_register->value == 'yes'){
            return $next($request);
        }

        return abort(404);
    }
}
