<?php

namespace App\Http\Requests;

/**
 * Class JWTTokenRequest
 *
 * @package App\Http\Requests
 */
class JWTTokenRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email'     => 'required | exists:users,email',
            'password'  => 'required'
        ];
    }
}
