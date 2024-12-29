<?php

namespace App\Http\Controllers\Api\User;

use App\Exceptions\CustomExceptionHandler;
use App\Helpers\UploadFileHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\UpdateProfileRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Exception;
use Illuminate\Database\QueryException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

class UpdateProfileController extends Controller
{
    public function __invoke(UpdateProfileRequest $request, User $user)
    {
        try {
            $inputs = $request->validated();
            if ($request->avatar_url != null) {
                if ($user->avatar_url != '') {
                    UploadFileHelper::deleteFileOnDisk($user->avatar_url);
                }
                $inputs['avatar_url'] =
                    UploadFileHelper::uploadFile(
                        $request->avatar_url,
                        'user/avatar/',
                        'image'
                    );
                $user->update($inputs);
            } else {
                $user->update($inputs);
            }

            return response()->json(['user' => UserResource::make($user)], Response::HTTP_CREATED);
        } catch (Exception $exception) {
            $handler = new CustomExceptionHandler();
            return $handler->render($request, $exception);
        }
    }
}
