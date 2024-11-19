<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

class UserProfileController extends Controller
{
    public function __invoke(Request $request)
    {
        try {
            $user= auth()->user();
            return response()->json([
                'user' => UserResource::make($user),
                'token'=>$request->bearerToken()
            ],Response::HTTP_OK);
        }catch (HttpException $exception){
            return response()->json([
                'message' => 'Something went wrong'
            ],$exception->getStatusCode());
        }
    }
}
