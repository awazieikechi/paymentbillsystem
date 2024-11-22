<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

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
        $this->renderable(function (AccessDeniedHttpException $e, $request) {
            if ($request->is('api/*')) {
                return response()->json(['message' => "You Don't Have Permission to access this Resource"]);
            }
        });

        $this->renderable(function (NotFoundHttpException $e) {
            if (request()->is('api/*') && ($e->getPrevious() instanceof \Illuminate\Database\Eloquent\ModelNotFoundException)) {
                $model = Str::afterLast($e->getPrevious()->getModel(), '\\'); //extract Model name
                return response()->json(['message' => $model . ' not found', 404]);
            }
        });

        $this->reportable(function (\League\OAuth2\Server\Exception\OAuthServerException $e) {
            if ($e->getCode() == 9) {
                return false;
            }

        });
    }
}
