<?php

namespace App\Http\Controllers\Api\User;

use App\Exceptions\CustomExceptionHandler;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;
use Symfony\Component\HttpKernel\Exception\HttpException;

class RegisterNewUserController extends Controller
{
    public function __invoke(RegisterRequest $request)
    {
        try {
            $request->validated();
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'role_id' => $request->role_id,
                'password' => Hash::make($request->password),
            ]);
            return response()->json(
                [
                    'user' => new UserResource($user),
                    'success' => true
                ],
                ResponseAlias::HTTP_CREATED
            );
        } catch (Exception $exception) {
            $handler = new CustomExceptionHandler();
            return $handler->render($request, $exception);
        }
    }
}
