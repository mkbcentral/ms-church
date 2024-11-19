<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

class LogoutController extends Controller
{
    public function __invoke()
    {
        try {
            auth()->user()->tokens()->delete();
            return response([
                'message' => 'user logged out successfully.',
            ], Response::HTTP_OK);
        } catch (HttpException $ex) {
            return response([
                'error' => $ex->getMessage(),
            ], $ex->getStatusCode());
        }
    }
}
