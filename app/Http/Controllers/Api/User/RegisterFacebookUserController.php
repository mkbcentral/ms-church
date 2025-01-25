<?php

namespace App\Http\Controllers\Api\User;

use App\Exceptions\CustomExceptionHandler;
use App\Helpers\LoginHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\FacebookUserRequest;
use App\Http\Requests\User\GoogleUserRequest;
use App\Models\User;
use Exception;
use Hash;
use Illuminate\Http\Request;

class RegisterFacebookUserController extends Controller
{
    public function __invoke(FacebookUserRequest $request)
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
                    'fbk_avatar_url' => $fields['fbk_avatar_url'],
                    'is_facebook' => true,
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
