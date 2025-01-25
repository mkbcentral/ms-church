<?php

namespace App\Http\Controllers\Api\User;

use App\Exceptions\CustomExceptionHandler;
use App\Http\Controllers\Controller;
use Auth;
use Exception;
use Illuminate\Database\QueryException;
use Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

class LogoutController extends Controller
{
    public function __invoke(Request $request)
    {
        try {
            Auth::user()->tokens()->delete();
            return response([
                'message' => 'Vous êtes bien déconnecté.',
                'success' => true,
            ], Response::HTTP_OK);
        } catch (Exception $exception) {
            $handler = new CustomExceptionHandler();
            return $handler->render($request, $exception);
        }
    }
}
