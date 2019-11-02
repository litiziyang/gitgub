<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

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
     * Report or log an exception.
     *
     * @param Exception $exception
     *
     * @return void
     * @throws Exception
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param Request   $request
     * @param Exception $exception
     *
     * @return Response
     * @throws Exception
     */
    public function render($request, Exception $exception)
    {
        // return parent::render($request, $exception);
        // DB::rollBack();
        if ($exception instanceof ModelNotFoundException) {
            $exception = new Exception('未知错误');
        }
        $exceptionMessage = $exception->getMessage();
        switch ($exceptionMessage) {
            case 'This action is unauthorized.':
                $exceptionMessage = '权限不足';
                break;
            default:
                break;
        }
        \DB::rollBack();
        return response()->json(['code' => 400, 'msg' => $exceptionMessage], 400);
    }
}
