<?php

namespace App\Exceptions;

/**
 * Class HeaderNotSupportedException
 *
 * @package App\Exceptions
 */
class HeaderNotSupportedException extends StandardizedErrorResponseException
{
    /**
     * Send back a HTTP code
     *
     * @var int
     */
    protected $code = 422;

    /**
     * Error message that will be sent back to the user
     *
     * @var string
     */
    protected $message = 'Resource content type is not supported.';
}
