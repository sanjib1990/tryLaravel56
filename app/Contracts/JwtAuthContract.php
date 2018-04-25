<?php

namespace App\Contracts;

use Illuminate\Http\Request;

/**
 * Interface JwtAuthContract
 *
 * @package App\Contracts
 */
interface JwtAuthContract
{
    /**
     * Authenticate the user and generate token.
     *
     * @param array $data
     *
     * @return mixed
     */
    public function token(array $data);

    /**
     * Refrest the generated token.
     *
     * @return mixed
     */
    public function refreshToken(): string;

    /**
     * Validate the authentication token.
     *
     * @param array $data
     *
     * @return mixed
     */
    public function validate(array $data);

    /**
     * Invalidate the token.
     *
     * @return mixed
     */
    public function invalidate();
}
