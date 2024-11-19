<?php

namespace App\Http\Controllers\Api\Church;

use App\Helpers\UploadFileHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Church\CreateChurchRequest;
use App\Http\Requests\Church\UpdateChurchRequest;
use App\Http\Resources\ChurchResource;
use App\Models\Church;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

class CrudChurchController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $churches=Church::query()
                    ->when(request()->search, function ($query, $search) {
                        return $query->where('name', 'like', '%' . $search . '%');
                    })
                    ->orderBy('created_at','desc')
                    ->orderBy('name','asc')
                    ->where('user_id',auth()->user()->id)
                    ->paginate(5);
            return response([
                'churches' => ChurchResource::collection($churches),
            ], Response::HTTP_OK);

        }catch (HttpException $exception){
            return response()->json(
                [
                    'error' => $exception->getMessage(),
                    'success' => false,
                ],
                $exception->getStatusCode()
            );
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateChurchRequest $request)
    {
        try {
            $fields= $request->validated();
            $fields['logo']=UploadFileHelper::uploadFile(
                $request->logo,
                'church/logos/',
                'image'
            );
            auth()->user()->church()->create($fields);
            return response()->json([
                'success' => true,
            ],Response::HTTP_CREATED);
        }catch (HttpException $exception) {
            return response()->json(
                [
                    'error' => $exception->getMessage(),
                    'success' => false,
                ],
                $exception->getStatusCode()
            );
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Church $church)
    {
        try {
            return response()->json([
                'church'=>ChurchResource::make($church)
            ],Response::HTTP_OK);
        }catch (HttpException $exception) {
            return response()->json(
                [
                    'error' => $exception->getMessage(),
                    'success' => false,
                ]
            );
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateChurchRequest $request, Church $church)
    {
        try {
            $fields= $request->validated();
            $church->update($fields);
            return response()->json([
                'success' => true,
            ],Response::HTTP_CREATED);
        }catch (HttpException $exception) {
           return response()->json(
               [
                   'error' => $exception->getMessage(),
                   'success' => false,
               ],$exception->getStatusCode()
           );
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Church $church)
    {
        try {
            $church->delete();
            return response()->json([
                'success' => true,
            ],Response::HTTP_OK);
        }catch (HttpException $exception) {
            return response()->json(
                [
                    'error' => $exception->getMessage(),
                    'success' => false,
                ],$exception->getStatusCode()
            );
        }

    }
}
