<?php

namespace App\Http\Controllers\Api\User;

use App\Exceptions\CustomExceptionHandler;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\LoginRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

class LoginUserController extends Controller
{
    public function __invoke(LoginRequest $request)
    {
        try {
            $request->validated();
            $user = User::where('email', $request->login)
                ->orWhere('phone', $request->login)
                ->first();
            if (!$user || !Hash::check($request->password, $user->password)) {
                return response([
                    'error' => 'The provided credentials are incorrect.',
                ], Response::HTTP_INTERNAL_SERVER_ERROR);
            } else {
                $token = $user->createToken('token')->plainTextToken;
                return response([
                    'user' => new UserResource($user),
                    'token' => $token,
                    'success' => true
                ], Response::HTTP_OK);
            }
        } catch (Exception $exception) {
            $handler = new CustomExceptionHandler();
            return $handler->render($request, $exception);
        }
    }
}
