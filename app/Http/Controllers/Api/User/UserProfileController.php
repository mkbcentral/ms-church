<?php

namespace App\Http\Controllers\Api\User;

use App\Exceptions\CustomExceptionHandler;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Auth;
use Exception;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

class UserProfileController extends Controller
{
    public function __invoke(Request $request)
    {
        try {
            $user = Auth::user();
            return response()->json(
                [
                    'user' => UserResource::make($user),
                    'token' => $request->bearerToken()
                ],
                Response::HTTP_OK
            );
        } catch (Exception $exception) {
            $handler = new CustomExceptionHandler();
            return $handler->render($request, $exception);
        }
    }
}
