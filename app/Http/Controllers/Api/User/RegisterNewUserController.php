<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\RegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;
use Symfony\Component\HttpKernel\Exception\HttpException;

class RegisterNewUserController extends Controller
{
    public function __invoke(RegisterRequest $request)
    {
        try {
            $request->validated();
            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'password' => Hash::make($request->password),
            ]);
            return response()->json(
                ['message' => 'User registered'],
                ResponseAlias::HTTP_CREATED);
        } catch (HttpException $exception) {
            return response()->json(
                [
                    'message' => $exception->getMessage()
                ],
                $exception->getStatusCode()
            );
        }
    }
}
