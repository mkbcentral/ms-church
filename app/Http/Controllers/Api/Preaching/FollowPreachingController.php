<?php

namespace App\Http\Controllers\Api\Preaching;

use App\Exceptions\CustomExceptionHandler;
use App\Http\Controllers\Controller;
use App\Http\Resources\PreachingResource;
use App\Models\Preaching;
use Exception;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

class FollowPreachingController extends Controller
{
    public function follow(Request $request, Preaching $preaching)
    {
        try {
            $count = auth()->user()->preachingFollows()->count();
            if ($count <= 10) {
                auth()->user()->preachingFollows()->sync($preaching);
                return response()->json(['success' => true], Response::HTTP_CREATED);
            } else {
                return response()->json(['success' => false], Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        } catch (Exception $exception) {
            $handler = new CustomExceptionHandler();
            return $handler->render($request, $exception);
        }
    }

    public function recommandations(Request $request)
    {
        try {
            $preachings = Preaching::withCount('views')
                ->where('views_count', '=', 1)
                ->orderBy('created_at', 'desc')
                ->take(10) // Limiter à 4 prêches
                ->get();

            return PreachingResource::collection($preachings);
        } catch (Exception $exception) {
            $handler = new CustomExceptionHandler();
            return $handler->render($request, $exception);
        }
    }
}
