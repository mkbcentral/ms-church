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

class SearchPreachingController extends Controller
{
    public function index(Request $request)
    {
        try {
            $search = $request->input('search');
            $preachings = [];
            // Appliquer le filtre de recherche si le paramètre est présent
            if ($search) {
                $preachings =
                    Preaching::join('churches', 'churches.id', '=', 'preachings.church_id')
                    ->orderBy('preachings.created_at', 'desc')
                    ->where('preachings.title', 'like', '%' . $search . '%')
                    ->orWhere('preachings.preacher', 'like', '%' . $search . '%')
                    ->orWhere('churches.name', 'like', '%' . $search . '%')
                    ->orWhere('churches.abbreviation', 'like', '%' . $search . '%')
                    ->select('preachings.*')
                    ->get();
            }
            return response()->json([
                'preachings' =>  PreachingResource::collection($preachings),
            ], Response::HTTP_OK);
        } catch (Exception $exception) {
            $handler = new CustomExceptionHandler();
            return $handler->render($request, $exception);
        }
    }
}
