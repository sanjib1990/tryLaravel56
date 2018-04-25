<?php

namespace App\Http\Controllers\API\V1\Auth;

use App\Contracts\JwtAuthContract;
use App\Http\Controllers\Controller;
use App\Http\Requests\JWTTokenRequest;

/**
 * Class AuthenticationController
 *
 * @package App\Http\Controllers\API\V1\Auth
 */
class AuthenticationController extends Controller
{
    /**
     * @var \App\Contracts\JwtAuthContract
     */
    private $jwtAuth;

    /**
     * AuthenticationController constructor.
     *
     * @param \App\Contracts\JwtAuthContract $jwtAuth
     */
    public function __construct(JwtAuthContract $jwtAuth)
    {
        $this->jwtAuth = $jwtAuth;
    }

    /**
     * Get the token for the given credentials.
     *
     * @param \App\Http\Requests\JWTTokenRequest $request
     *
     * @return mixed
     */
    public function token(JWTTokenRequest $request)
    {
        return $this->tokenResponse($this->jwtAuth->token($request->all()));
    }

    /**
     * Logout.
     */
    public function logout()
    {
        $this->jwtAuth->invalidate();

        return response()->jsend(null, trans('api.success'));
    }

    /**
     * Get the refresh token.
     *
     * @return mixed
     */
    public function refresh()
    {
        return $this->tokenResponse($this->jwtAuth->refreshToken());
    }

    /**
     * Get the logged in user details.
     *
     * @return mixed
     */
    public function user()
    {
        return response()->jsend(auth()->user(), trans('api.success'));
    }

    /**
     * Get the token response.
     *
     * @param string $token
     *
     * @return mixed
     */
    private function tokenResponse(string $token)
    {
        return response()->jsend([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ], trans('api.success'), 200, [
            'X-AUTHORIZATION' => $token
        ]);
    }
}
