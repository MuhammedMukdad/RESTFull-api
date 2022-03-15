<?php

namespace App\Exceptions;

use Exception;
use Throwable;
use App\Traits\ApiResponser;
use PhpParser\Node\Stmt\If_;
use InvalidArgumentException;
use Illuminate\Database\QueryException;
use Dotenv\Exception\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;

class Handler extends ExceptionHandler
{
    use ApiResponser;
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
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
        $this->renderable(function (Exception $e) {
/*
            // if($e instanceof ValidationException){
            //     return $this->errorResponse("errorrrrrrrrr",404);
            // }

            // if($e instanceof InvalidArgumentException){
            //     return $this->errorResponse("This model is not found",404);
            // }

            if($e instanceof MethodNotAllowedHttpException){
                return $this->errorResponse("This method for the request is invalid",405);
            }
            // if($e instanceof NotFoundHttpException){
            //     return $this->errorResponse("Not found",422);
            // }

            if($e instanceof HttpException){
                return $this->errorResponse("Exception",$e->getCode());
            }

            if($e instanceof QueryException){
                return $this->errorResponse("quer excepion",$e->getCode());
            }
            if(!config('app.debug')){
                return $this->errorResponse($e->getMessage(),500);
            }*/
        });
    }
}
