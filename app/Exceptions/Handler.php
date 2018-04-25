<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Contracts\Container\Container;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class Handler
 *
 * @package App\Exceptions
 */
class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * @var int $code
     */
    private $code = 500;

    /**
     * @var $error
     */
    private $error;

    /**
     * @var $request
     */
    private $request;

    /**
     * @var array $validationErrors
     */
    private $validationErrors   = [];

    /**
     * Handler constructor.
     *
     * @param \Illuminate\Contracts\Container\Container $container
     * @param \Illuminate\Http\Request                  $request
     */
    public function __construct(Container $container, Request $request)
    {
        parent::__construct($container);

        $this->request = $request;
    }

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception $exception
     *
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function report(Exception $exception)
    {
        if (in_array('api', $this->request->segments()) ||  $this->request->ajax()) {
            return $this->handleApiErrors($this->request, $exception);
        }

        return parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     *
     * @return \Illuminate\Http\Response|\Symfony\Component\HttpFoundation\Response
     */
    public function render($request, Exception $exception)
    {
        if ($exception instanceof AuthenticationException && in_array('api', $exception->guards())) {
            return $this->handleApiErrors($request, $exception, 401);
        }

        if ($exception instanceof ModelNotFoundException) {
            $exception  = new NotFoundHttpException($exception->getMessage(), $exception);
        }

        if (in_array('api', $request->segments()) ||  $request->ajax() || $request->acceptsJson()) {
            return $this->handleApiErrors($request, $exception);
        }

        return parent::render($request, $exception);
    }

    /**
     * Returns the debug info only if app environment is not production
     *
     * @return array
     */
    public function getDebugInfo()
    {
        $info   = [
            'validation'    => $this->validationErrors
        ];

        if (env('APP_ENV') == 'prod') {
            return $info;
        }

        $info['http']   = [
            'host'      => $this->request->getHost(),
            'method'    => $this->request->getMethod(),
            'url'       => $this->request->fullUrl(),
            'body'      => $this->request->getContent(),
            'inputs'    => $this->request->all(),
            'headers'   => $this->request->header()
        ];

        $info['debug']   = [
            'realm'         => env('APP_ENV'),
            'exception'     => get_class($this->error),
            'file'          => $this->error->getFile(),
            'line'          => $this->error->getLine(),
            'stack_trace'   => $this->error->getTrace()
        ];

        return $info;
    }

    /**
     * @param Request   $request
     * @param Exception $exception
     * @param null      $code
     *
     * @return \Illuminate\Http\Response
     */
    private function handleApiErrors(Request $request, Exception $exception, $code = null)
    {
        $this->request  = $request;
        $this->error    = $exception;
        $this->code     = $code ?? $this->setStatusCode();

        if (method_exists($this->error, 'getValidationErrors')) {
            $this->validationErrors = $this->error->getValidationErrors();
        }

        return response()->jsend($this->getDebugInfo(), $this->getMessage(), $this->code);
    }

    /**
     * @return int|string
     */
    private function setStatusCode()
    {
        if ($this->error instanceof HttpException) {
            return $this->error->getStatusCode();
        }

        if ($this->error->getCode() >= 100 && $this->error->getCode() <= 600) {
            return $this->error->getCode();
        }

        return 500;
    }

    /**
     * Custom messages for certain error codes
     *
     * @return string
     */
    private function getMessage()
    {
        if (! empty($this->error->getMessage())) {
            return $this->error->getMessage();
        }

        return Response::$statusTexts[$this->code];
    }
}
