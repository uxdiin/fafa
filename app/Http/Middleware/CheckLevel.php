<?php

namespace App\Http\Middleware;

use Closure;
use App\User;

class CheckLevel
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user_id = Auth::id();
        $user = User::findOrFail(id);
        return $next($request);
    }
}
