<?php

namespace App\Http\Controllers\Api\Preaching;

use App\Http\Controllers\Controller;
use App\Http\Resources\PreachingResource;
use App\Models\Preaching;
use Symfony\Component\HttpKernel\Exception\HttpException;

class RecentPreachingsController extends Controller
{
    public function index(\Request $request )
    {
        try {
            $preachings=Preaching::query()
                ->where('created_at', '<=', now())
                ->orderBy('created_at','desc')
                ->take(10)
                ->get();
            return PreachingResource::collection($preachings);
        }catch (HttpException $exception){
            return response()->json(
                ['error'=>$exception->getMessage()]
                ,$exception->getStatusCode()
            );
        }
    }
}
