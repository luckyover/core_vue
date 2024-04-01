<?php

namespace App\Exceptions;

use AnsResponse;
use App\Models\AnsException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use ResponseCode;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
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
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $exception)
    {
        try {
            $statusCode = ResponseCode::SERVICE_ERROR;
            if ($exception instanceof \Illuminate\Auth\AuthenticationException
                || $exception instanceof \PHPOpenSourceSaver\JWTAuth\Exceptions\TokenExpiredException
                || $exception instanceof \PHPOpenSourceSaver\JWTAuth\Exceptions\TokenInvalidException
                || $exception instanceof \PHPOpenSourceSaver\JWTAuth\Exceptions\JWTException) {
                $statusCode = ResponseCode::UNAUTHORIZED;
            } elseif (get_class($exception) === 'App\Exceptions\NotAcceptableException') {
                $statusCode = ResponseCode::NOT_ACCEPTABLE;
            } elseif (method_exists($exception, 'getStatusCode')) {
                $statusCode = $exception->getStatusCode();
            }
            $response = new AnsResponse;
            $response = $this->SetException($response, $exception);
            $response->code = $statusCode;
            if ($statusCode === ResponseCode::UNAUTHORIZED
                || $statusCode === ResponseCode::FORBIDDEN
                || $statusCode === ResponseCode::NOT_FOUND
                || $statusCode === ResponseCode::NOT_ACCEPTABLE) {
                $response->messageNo = 'E' . $statusCode;
            }
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json($response, $statusCode);
            } else {
                if (config('app.debug') && $statusCode == 500) {
                    dd($exception);
                }

                return redirect()->route('Error' . $statusCode);
            }
        } catch (\Exception $e) {
            if ($request->ajax() || $request->wantsJson()) {
                $response = new AnsResponse;
                $response = $this->SetException($response, $e);

                return response()->json($response, ResponseCode::SERVICE_ERROR);
            } else {
                if (config('app.debug')) {
                    dd($e);
                }

                return redirect()->route('ServerError', ['error' => $e->getMessage()]);
            }
        }

        return parent::render($request, $exception);
    }

    private function SetException(AnsResponse $response, Throwable $e): AnsResponse
    {
        $response->code = ResponseCode::SERVICE_ERROR;
        $response->message = $e->getMessage();
        $response->messageNo = 'E500';
        $response->dataError = new AnsException;
        $response->dataError->instance = get_class($e);
        $response->dataError->line = $e->getLine();
        $response->dataError->file = basename($e->getFile());
        $response->dataError->code = $e->getCode();
        $response->dataError->message = $response->message;
        if (get_class($e) === 'App\Exceptions\NotAcceptableException') {
            $response->data = $e->getErrors();
        }

        return $response;
    }
}
