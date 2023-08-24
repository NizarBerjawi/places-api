<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Illuminate\Http\Response;
use Spatie\QueryBuilder\Exceptions\InvalidIncludeQuery;
use Spatie\QueryBuilder\Exceptions\InvalidQuery;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $exception)
    {
        if ($request->ajax() || $request->wantsJson() || $request->is('api/*')) {
            return $this->prepareJsonResponse($request, $exception);
        }

        return parent::render($request, $exception);
    }

    /**
     * Prepare a JSON response for the given exception.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    protected function prepareJsonResponse($request, Throwable $e)
    {
        $debugEnabled = config('app.debug');

        if (
            $e instanceof NotFoundHttpException ||
            $e instanceof ModelNotFoundException
        ) {
            $message = 'The specified resource could not be found.';
            $statusCode = Response::HTTP_NOT_FOUND;
        }

        if ($e instanceof InvalidQuery) {
            $message = $e->getMessage();
            $statusCode = Response::HTTP_NOT_FOUND;
        }

        if ($e instanceof InvalidIncludeQuery) {
            $message = "Requested include(s) `{$e->unknownIncludes->implode(', ')}` are not allowed.";
            $statusCode = Response::HTTP_NOT_FOUND;
        }

        if ($e instanceof QueryException) {
            $message = Response::$statusTexts[Response::HTTP_INTERNAL_SERVER_ERROR];
            $statusCode = Response::HTTP_INTERNAL_SERVER_ERROR;
        }

        if ($e instanceof AuthenticationException) {
            $message = 'Invalid API key or access token.';
            $statusCode = Response::HTTP_UNAUTHORIZED;
        }

        if ($e instanceof ThrottleRequestsException) {
            $limit = $e->getHeaders()['X-RateLimit-Limit'];
            $statusCode = $this->getStatusCode($e);
            $message = "Exceeded $limit calls per minute for API client. Reduce request rates to resume uninterrupted service.";
        }

        if (! isset($message)) {
            $statusCode = $this->getStatusCode($e);
            $message = sprintf('%s', Response::$statusTexts[$statusCode]);
        }

        $errors = [
            'message' => $message,
            'statusCode' => $statusCode,
        ];

        if ($debugEnabled) {
            $errors['exception'] = get_class($e);
            $errors['trace'] = explode("\n", $e->getTraceAsString());
        }

        return response()->json(['errors' => $errors], $statusCode);
    }

    /**
     * Get the status code from the exception.
     *
     * @return int
     */
    protected function getStatusCode(Throwable $exception)
    {
        return $exception instanceof HttpExceptionInterface
            ? $exception->getStatusCode()
            : 500;
    }
}
