<?php

namespace App\Http\Controllers\Api\Preaching;

use App\Http\Controllers\Controller;
use App\Http\Resources\PreachingResource;
use App\Models\Preaching;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

class FollowPreachingController extends Controller
{
    public function follow(Request $request, Preaching $preaching)
    {
        try {
            $user = auth()->user();
            $user->followedPreachings()->attach($preaching);
            return response()->json(['success' => true], Response::HTTP_CREATED);
        }catch (HttpException $exception){
            return  response()->json(
                ['success'=>false, 'error' => $exception->getMessage()],
                $exception->getStatusCode()
            );
        }
    }

    public function recommendations(Request $request)
    {
        try {
            $user=auth()->user();
            $preachings = Preaching::withCount('views')
                ->orderBy('views_count', 'desc')
                ->take(4) // Limiter à 4 prêches
                ->get();
            return PreachingResource::collection($preachings);
        }catch (HttpException $exception){
            return  response()->json(
                ['success'=>false, 'error' => $exception->getMessage()],
                $exception->getStatusCode()
            );
        }

    }

}
