<?php

namespace BrandStudio\Devil\Exceptions;
use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\Mail;
use BrandStudio\Devil\Mail\SendErrorToDevelopers;

class Handler extends ExceptionHandler
{

    protected $dontReport = [
        //
    ];

    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    public function report(Exception $exception)
    {
        parent::report($exception);

    }

    public function render($request, Exception $exception)
    {
        $response = parent::render($request, $exception);
        try {
            if (!config('devil.enabled') || $response->getStatusCode() < 500) {
                return $response;
            }

            $error_message = [
                'user' => $request->user() ? $request->user()->id : '',
                'exception_message' => $exception->getMessage(),
                'file' => $exception->getFile(),
                'line' => $exception->getLine(),
                'url' => $request->fullUrl(),
                'pathInfo' => $request->getPathInfo(),
                'requestUri' => $request->getRequestUri(),
                'method' => $request->getMethod(),
                'backpack_user' => backpack_user() ? backpack_user()->id : '',
            ];

            $trace =  json_encode(array_slice($exception->getTrace(), 0, 10), JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);

            $users = config('devil.emails');
            Mail::to($users)->send(new SendErrorToDevelopers($trace, $error_message));

        } catch(\Exception $e) {
            // dd($e);
        } finally {
            return $response;
        }
    }
}
