<?php

namespace App\Http\Middleware;

use Closure;

/**
 * Class JWTRefreshTokenMiddleware
 *
 * @package App\Http\Middleware
 */
class JWTRefreshTokenMiddleware
{
    /**
     * JWTRefreshTokenMiddleware constructor.
     */
    public function __construct()
    {
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        return $next($request);
    }
}
