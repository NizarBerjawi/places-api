<?php

namespace App\Exceptions;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Response;
use Laravel\Lumen\Exceptions\Handler as ExceptionHandler;
use Spatie\QueryBuilder\Exceptions\InvalidIncludeQuery;
use Spatie\QueryBuilder\Exceptions\InvalidQuery;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Throwable  $exception
     * @return void
     *
     * @throws \Exception
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $exception)
    {
        return $this->prepareJsonResponse($request, $exception);
    }

    /**
     * Prepare a JSON response for the given exception.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $e
     * @return \Illuminate\Http\JsonResponse
     */
    protected function prepareJsonResponse($request, Throwable $e)
    {
        $debugEnabled = config('app.debug');

        if ($this->shouldntReport($e)) {
            return;
        }

        if (
            $e instanceof NotFoundHttpException ||
            $e instanceof ModelNotFoundException
        ) {
            $message = 'The specified resource could not be found';
            $statusCode = 404;
        }

        if ($e instanceof InvalidQuery) {
            $message = $e->getMessage();
            $statusCode = 404;
        }

        if ($e instanceof InvalidIncludeQuery) {
            $message = "Requested include(s) `{$e->unknownIncludes->implode(', ')}` are not allowed.";
            $statusCode = 404;
        }

        if ($e instanceof QueryException) {
            $message = 'Internal Server Error';
            $statusCode = 500;
        }

        if (! isset($message)) {
            $statusCode = $this->getStatusCode($e);
            $message = sprintf('%s', Response::$statusTexts[$statusCode]);
        }

        $errors = [
            'message' => $message,
            'status_code' => $statusCode,
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
     * @param \Throwable $exception
     * @return int
     */
    protected function getStatusCode(Throwable $exception)
    {
        return $exception instanceof HttpExceptionInterface
            ? $exception->getStatusCode()
            : 500;
    }
}
