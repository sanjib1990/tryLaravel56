<?php

namespace App\Http\Middleware;

use Closure;
use Tymon\JWTAuth\JWTAuth;
use Illuminate\Events\Dispatcher;
use Illuminate\Contracts\Routing\ResponseFactory;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

/**
 * Class JwtMiddleware
 *
 * @package App\Http\Middleware
 */
class JwtMiddleware
{
    /**
     * @var \Tymon\JWTAuth\JWTAuth
     */
    private $auth;

    /**
     * @var \Illuminate\Contracts\Routing\ResponseFactory
     */
    private $response;

    /**
     * @var \Illuminate\Events\Dispatcher
     */
    private $events;

    /**
     * JwtMiddleware constructor.
     *
     * @param \Tymon\JWTAuth\JWTAuth                        $auth
     * @param \Illuminate\Contracts\Routing\ResponseFactory $response
     * @param \Illuminate\Events\Dispatcher                 $events
     */
    public function __construct(JWTAuth $auth, ResponseFactory $response, Dispatcher $events)
    {
        $this->auth     = $auth;
        $this->events   = $events;
        $this->response = $response;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure                 $next
     *
     * @return mixed
     * @throws \Exception
     */
    public function handle($request, Closure $next)
    {
        $auth = $this->auth->setRequest($request);

        if (! $auth->getToken()) {
            return $this->respond('tymon.jwt.absent', 'token_not_provided', 401);
        }

        try {
            $user = $auth->authenticate();
        } catch (TokenExpiredException $e) {
            return $this->respond('tymon.jwt.expired', 'token_expired', 401, [$e]);
        } catch (TokenInvalidException $e) {
            return $this->respond('tymon.jwt.invalid', 'token_invalid', 401, [$e]);
        }

        $this->events->fire('tymon.jwt.valid', $user);

        return $next($request);
    }

    /**
     * Fire event and return the response.
     *
     * @param  string $event
     * @param  string $error
     * @param  int    $status
     * @param  array  $payload
     *
     * @return mixed
     * @throws \Exception
     */
    protected function respond($event, $error, $status, $payload = [])
    {
        $response = $this->events->fire($event, $payload, true);

        if ($response) {
            return $response;
        }

        throw new \Exception(trans('api.'.$error), $status);
    }
}
