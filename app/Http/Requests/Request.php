<?php
/**
 * Created by PhpStorm.
 * User: sanjib
 * Date: 25/04/18
 * Time: 4:59 PM
 */

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Exceptions\InvalidUserInputException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Auth\Access\AuthorizationException;

/**
 * Class Request
 *
 * @package App\Http\Requests
 */
abstract class Request extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    abstract public function rules();

    /**
     * @param Validator $validator
     *
     * @return array|void
     * @throws InvalidUserInputException
     */
    protected function failedValidation(Validator $validator)
    {
        throw new InvalidUserInputException(null, 400, null, $validator->errors());
    }

    /**
     * Handle a failed authorization attempt.
     *
     * @return void
     * @throws AuthorizationException
     */
    protected function failedAuthorization()
    {
        throw new AuthorizationException();
    }
}
