<?php

namespace App\Utils;

use Tymon\JWTAuth\JWTAuth;
use App\Contracts\JwtAuthContract;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Exceptions\InvalidUserInputException;
use Tymon\JWTAuth\Manager;

/**
 * Class JWTAuthenticator
 *
 * @package App\Utils
 */
class JWTAuthenticator implements JwtAuthContract
{
    /**
     *
     * @var \Tymon\JWTAuth\JWTAuth
     */
    private $auth;

    /**
     * @var \Tymon\JWTAuth\Manager
     */
    private $manager;

    /**
     * JWTAuthenticator constructor.
     *
     * @param \Tymon\JWTAuth\JWTAuth $auth
     * @param \Tymon\JWTAuth\Manager $manager
     */
    public function __construct(JWTAuth $auth, Manager $manager)
    {
        $this->auth = $auth;
        $this->manager = $manager;
    }

    /**
     * Authenticate the user and generate token.
     *
     * @param array $data
     *
     * @return string
     * @throws \Exception
     */
    public function token(array $data): string
    {
        try {
            if (! $token = $this->auth->attempt(['email' => $data['email'], 'password' => $data['password']])) {
                throw new InvalidUserInputException(trans("api.validations.auth"), 400, null, [
                    'input' => trans("api.validations.auth")
                ]);
            }

            return $token;
        } catch (JWTException $exception) {
            throw new \Exception($exception);
        }
    }

    /**
     * Refrest the generated token.
     *
     * @return string
     * @throws \Tymon\JWTAuth\Exceptions\JWTException
     */
    public function refreshToken(): string
    {
        $oldToken = $this->auth->getToken();
        $newToken = $this->auth->manager()->setBlacklistEnabled(false)->refresh($oldToken);

        $this->auth->manager()->setBlacklistEnabled(true)->invalidate($oldToken);

        return $newToken;
    }

    /**
     * Validate the authentication token.
     *
     * @param array $data
     *
     * @return mixed
     */
    public function validate(array $data)
    {
    }

    /**
     * Invalidate the token.
     *
     * @throws \Tymon\JWTAuth\Exceptions\JWTException
     */
    public function invalidate()
    {
        $this->auth->manager()->setBlacklistEnabled(true)->invalidate($this->auth->getToken());
    }
}
