<?php

namespace App\Http\Middleware;

use Auth;
use Closure;

class MustBeAdmin
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
        // 确保当前用户是管理员
        if (Auth::guest() || !Auth::user()->is_admin) {
            abort(404);
        }

        return $next($request);
    }
}
