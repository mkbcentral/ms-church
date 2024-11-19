<?php

namespace App\Http\Controllers\Api\Church;

use App\Http\Controllers\Controller;
use App\Http\Resources\ChurchResource;
use App\Models\Church;
use App\Models\Follower;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

class FollowChurchController extends Controller
{
    public function follow(Request $request, Church $church)
    {
        try {
            $exists = Follower::where('user_id', $request->user()->id)
                ->where('church_id', $church->id)
                ->exists();
            if ($exists) {
                return response()->json(
                    [ 'success' => false],
                    Response::HTTP_BAD_REQUEST
                );
            }
            Follower::create([
                'user_id' => $request->user()->id,
                'church_id' => $church->id,
            ]);
            return response()->json(
                [ 'success' => true,],
                Response::HTTP_CREATED
            );

        }catch (HttpException $exception){
            return response()->json(
                [
                    'error'=>$exception->getStatusCode(),
                    'success' => false,
                ]
            );
        }
    }

    public function unfollow(Request $request, Church $church)
    {
        try {
            $deleted = Follower::where('user_id', $request->user()->id)
                ->where('church_id', $church->id)
                ->delete();
            if ($deleted) {
                return response()->json(
                    [ 'success' => true]
                );
            } else {
                return response()->json(
                    [ 'success' => false]
                );
            }
        }catch (HttpException $exception){
            return response()->json(
                [
                    'error'=>$exception->getStatusCode(),
                    'success' => false,
                ]
            );
        }

    }

    public function followedChurches(Request $request)
    {
        $churches = auth()->user()->followers()
            ->join('churches', 'followers.church_id', '=', 'churches.id')
            ->orderBy('churches.name', 'asc')
            ->orderBy('updated_at','desc')
            ->select('churches.*')
            ->get();
        return ChurchResource::collection($churches);
    }
}
