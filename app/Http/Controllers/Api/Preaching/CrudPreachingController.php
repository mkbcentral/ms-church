<?php

namespace App\Http\Controllers\Api\Preaching;

use App\Helpers\UploadFileHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Preaching\CreatePreachingRequest;
use App\Http\Requests\Preaching\UpdatePreachingRequest;
use App\Http\Resources\PreachingResource;
use App\Models\Preaching;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

class CrudPreachingController extends Controller
{
    public function index()
    {
        try {
            $preachings = Preaching::query()
                ->join('churches','churches.id','=','preachings.church_id')
                ->orderBy('preachings.created_at', 'desc')
                ->when(request()->search, function ($query, $search) {
                    return $query->where('preachings.title', 'like', '%' . $search . '%');
                })
                ->where('churches.user_id',auth()->user()->id)
                ->select('preachings.*')
                ->get();
            return response()->json([
                'preaching' => PreachingResource::collection($preachings),
            ],Response::HTTP_OK);
        }catch (HttpException $exception) {
            return response()->json(
                [
                    'error' => $exception->getMessage(),
                    'success' => false
                ],
                $exception->getStatusCode()
            );
        }
    }

    public function store(CreatePreachingRequest $request)
    {
        try {
            $fields = $request->validated();
            $fields['church_id']=auth()->user()->church->id;
            $fields['audio_url']=UploadFileHelper::uploadFile(
                $request->audio_url,
                'church/preachings/',
                'audio'
            );
            Preaching::create($fields);
            return response()->json([
                'success' => true,
            ],Response::HTTP_CREATED);
        }catch (HttpException $exception) {
            return response()->json(
                [
                    'error' => $exception->getMessage(),
                    'success' => false
                ],
                $exception->getStatusCode()
            );
        }
    }

    public function show(Preaching $preaching)
    {
        try {
            return response()->json([
                'preaching' => PreachingResource::make($preaching),
            ],Response::HTTP_OK);
        }catch (HttpException $exception) {
            return response()->json(
                [
                    'error' => $exception->getMessage(),
                    'success' => false
                ],
                $exception->getStatusCode()
            );
        }
    }

    public function update(UpdatePreachingRequest $request, Preaching $preaching)
    {
        try {
            $fields = $request->validated();
            $preaching->update($fields);
            return response()->json([
                'success' => true,
            ],Response::HTTP_CREATED);
        }catch (HttpException $exception) {
            return response()->json(
                [
                    'error' => $exception->getMessage(),
                    'success' => false
                ],
                $exception->getStatusCode()
            );
        }
    }

    public function destroy(Preaching $preaching)
    {
        try {
            UploadFileHelper::deleteFileOnDisk($preaching->audio_url,'public');
            $preaching->delete();
            return response()->json([
                'success' => true,
            ],Response::HTTP_OK);
        }catch (HttpException $exception) {
            return response()->json(
                [
                    'error' => $exception->getMessage(),
                    'success' => false
                ],
                $exception->getStatusCode()
            );
        }
    }
}
