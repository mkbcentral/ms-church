<?php

namespace App\Http\Controllers\Api\Church;

use App\Exceptions\CustomExceptionHandler;
use App\Http\Controllers\Controller;
use App\Http\Resources\ChurchResource;
use App\Models\Church;
use Exception;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

class ChurchesToFollowController extends Controller
{
    public function index()
    {
        try {
            $churches = Church::query()
                ->orderBy('created_at', 'desc')
                ->orderBy('name', 'asc')
                ->limit(10)
                ->get();
            return response([
                'churches' => ChurchResource::collection($churches),
            ], Response::HTTP_OK);
        } catch (Exception $exception) {
            $handler = new CustomExceptionHandler();
            return $handler->render(request(), $exception);
        }
    }
}
