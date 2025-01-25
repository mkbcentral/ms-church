<?php

namespace App\Helpers;

use App\Http\Resources\UserResource;
use App\Models\User;
use Hash;
use Symfony\Component\HttpFoundation\Response;

class LoginHelper
{
    public static function makeLogin(User $user)
    {

        if (!$user || !Hash::check('password', $user->password)) {
            return response([
                'error' => 'Mot de passe ou email iconrrect',
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        } else {
            $token = $user->createToken('token')->plainTextToken;
            return response([
                'user' => new UserResource($user),
                'token' => $token,
                'success' => true
            ], Response::HTTP_OK);
        }
    }
}
