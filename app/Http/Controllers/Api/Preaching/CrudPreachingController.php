<?php

namespace App\Http\Controllers\Api\Preaching;

use App\Exceptions\CustomExceptionHandler;
use App\Helpers\UploadFileHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Preaching\CreatePreachingRequest;
use App\Http\Requests\Preaching\UpdatePreachingRequest;
use App\Http\Resources\PreachingResource;
use App\Models\Church;
use App\Models\Preaching;
use App\Models\User;
use Exception;
use Gate;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CrudPreachingController extends Controller
{
    public function index()
    {
        try {;
            Gate::authorize('viewAny', Preaching::class);
            $preachings = Preaching::query()
                ->join('churches', 'churches.id', '=', 'preachings.church_id')
                ->orderBy('preachings.created_at', 'desc')
                ->when(request()->search, function ($query, $search) {
                    return $query->where('preachings.title', 'like', '%' . $search . '%');
                })
                ->where('churches.user_id', Auth::id())
                ->where('churches.id', Auth::user()->church->id)
                ->select('preachings.*')
                ->get();
            return response()->json([
                'preachings' => PreachingResource::collection($preachings),
            ], Response::HTTP_OK);
        } catch (Exception $exception) {
            $handler = new CustomExceptionHandler();
            return $handler->render(request(), $exception);
        }

        //NotFoundHttpException
    }

    public function store(CreatePreachingRequest $request)
    {
        try {
            Gate::authorize('create', Preaching::class);
            $fields = $request->validated();
            $fields['church_id'] = Auth::user()->church->id;
            $fields['audio_url'] = UploadFileHelper::uploadFile(
                $request->audio_url,
                'church/preachings/',
                'audio'
            );
            $fields['cover_url'] = UploadFileHelper::uploadFile(
                $request->cover_url,
                'church/covers/',
                'image'
            );
            $preaching = Preaching::create($fields);
            return response()->json(
                new PreachingResource($preaching),
                Response::HTTP_CREATED
            );
        } catch (Exception $exception) {
            $handler = new CustomExceptionHandler();
            return $handler->render($request, $exception);
        }
    }

    public function show(Preaching $preaching)
    {
        try {
            Gate::authorize('view', $preaching);
            return response()->json([
                'preaching' => new PreachingResource($preaching),
            ], Response::HTTP_OK);
        } catch (Exception $exception) {
            $handler = new CustomExceptionHandler();
            return $handler->render(request(), $exception);
        }
    }

    public function update(UpdatePreachingRequest $request, Preaching $preaching)
    {
        try {
            Gate::authorize('delete', $preaching);
            $fields = $request->validated();
            //Tester si le cover_url est soumis dans la requete
            if ($request->cover_url != null) {
                if ($preaching->cover_url != '') {
                    UploadFileHelper::deleteFileOnDisk($preaching->cover_url);
                }
                UploadFileHelper::deleteFileOnDisk($preaching->cover_url);
                $fields['cover_url'] = UploadFileHelper::uploadFile(
                    $request->cover_url,
                    'church/covers/',
                    'image'
                );
                $preaching->update([
                    'cover_url' => $fields['cover_url'],
                    'title' => $fields['title'],
                    'preacher' => $fields['preacher'],
                    'color' => $fields['color'],
                ]);
            } else if ($request->audio_url != null) {
                if ($preaching->audio_url != '') {
                    UploadFileHelper::deleteFileOnDisk($preaching->audio_url);
                }
                //Tester si le audio_url est soumis dans la requete
                UploadFileHelper::deleteFileOnDisk($preaching->audio_utl);
                $fields['audio_url'] = UploadFileHelper::uploadFile(
                    $request->audio_url,
                    'church/preachings/',
                    'audio'
                );
                $preaching->update([
                    'audio_url' => $fields['audio_url'],
                    'title' => $fields['title'],
                    'preacher' => $fields['preacher'],
                    'color' => $fields['color'],
                ]);
            } else {
                $preaching->update([
                    'title' => $fields['title'],
                    'preacher' => $fields['preacher'],
                    'color' => $fields['color'],
                ]);
            }
            return response()->json(
                new PreachingResource($preaching),
                Response::HTTP_CREATED
            );
        } catch (Exception $exception) {
            $handler = new CustomExceptionHandler();
            return $handler->render($request, $exception);
        }
    }

    public function destroy(Preaching $preaching)
    {
        try {
            UploadFileHelper::deleteFileOnDisk($preaching->audio_url, 'public');
            $preaching->delete();
            return response()->json([
                'success' => true,
            ], Response::HTTP_OK);
        } catch (Exception $exception) {
            $handler = new CustomExceptionHandler();
            return $handler->render(request(), $exception);
        }
    }
}
