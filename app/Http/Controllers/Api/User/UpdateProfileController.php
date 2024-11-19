<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\UpdateProfileRequest;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

class UpdateProfileController extends Controller
{
    public function __invoke(UpdateProfileRequest $request)
    {
        try {
            auth()->user()->update($request->validated());
            return response()->json([
                'message' => 'Profile updated successfully'
            ],Response::HTTP_CREATED);
        }catch (HttpException $exception){
            return response()->json([
                'message' => 'Something went wrong'
            ],$exception->getStatusCode());
        }
    }
}
