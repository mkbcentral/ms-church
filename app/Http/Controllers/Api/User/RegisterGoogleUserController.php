<?php

namespace App\Http\Controllers\Api\User;

use App\Exceptions\CustomExceptionHandler;
use App\Helpers\LoginHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\GoogleUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Exception;
use Hash;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RegisterGoogleUserController extends Controller
{
    public function __invoke(GoogleUserRequest $request)
    {
        try {
            $user = User::where('email', $request->email)->first();
            if ($user != null) {
                return LoginHelper::makeLogin($user);
            } else {
                $fields = $request->validated();
                $password = Hash::make('password');
                $user = User::create([
                    'name' => $fields['name'],
                    'email' => $fields['email'],
                    'google_avatar_url' => $fields['google_avatar_url'],
                    'is_google' => true,
                    'password' => $password,
                    'role_id' => $fields['role_id'],
                ]);
                return LoginHelper::makeLogin($user);
            }
        } catch (Exception $exception) {
            $handler = new CustomExceptionHandler();
            return $handler->render($request, $exception);
        }
    }
}
