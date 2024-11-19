<?php

namespace App\Http\Controllers\Api\Church;

use App\Http\Controllers\Controller;
use App\Http\Resources\ChurchResource;
use App\Models\Church;
use Symfony\Component\HttpKernel\Exception\HttpException;

class ChurchesToFollowController extends Controller
{
    public function index()
    {
        try {
            $preachings=Church::query()
                ->orderBy('created_at','desc')
                ->orderBy('name','asc')
                ->get();
            return ChurchResource::collection($preachings);
        }catch (HttpException $exception){
            return response()->json(
                ['error'=>$exception->getMessage()]
                ,$exception->getStatusCode()
            );
        }
    }
}
