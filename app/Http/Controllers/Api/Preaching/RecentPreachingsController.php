<?php

namespace App\Http\Controllers\Api\Preaching;

use App\Exceptions\CustomExceptionHandler;
use App\Http\Controllers\Controller;
use App\Http\Resources\PreachingResource;
use App\Models\Preaching;
use Exception;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

class RecentPreachingsController extends Controller
{
    public function index(\Request $request)
    {
        try {
            $preachings = Preaching::query()
                ->where('created_at', '<=', now())
                ->orderBy('created_at', 'desc')
                ->take(10)
                ->get();
            return response()->json([
                'preachings' =>  PreachingResource::collection($preachings),
            ], Response::HTTP_OK);
        } catch (Exception $exception) {
            $handler = new CustomExceptionHandler();
            return $handler->render($request, $exception);
        }
    }
}
