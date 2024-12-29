<?php

namespace App\Http\Controllers\Api\Preaching;

use App\Exceptions\CustomExceptionHandler;
use App\Http\Controllers\Controller;
use App\Http\Resources\PreachingResource;
use App\Models\Church;
use App\Models\Preaching;
use Exception;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;

class PreachingByChurchController extends Controller
{
    public function index(Request $request, Church $church)
    {
        try {
            $search = $request->input('search');
            $query = Preaching::orderBy('created_at', 'desc');
            // Appliquer le filtre de recherche si le paramètre est présent
            if ($search) {
                $query->where(function ($subQuery) use ($search) {
                    $subQuery->where('title', 'like', '%' . $search . '%')
                        ->orWhere('preacher', 'like', '%' . $search . '%');
                });
            }
            $preachings = $query->where('church_id', $church->id)->get();
            return PreachingResource::collection($preachings);
        } catch (Exception $exception) {
            $handler = new CustomExceptionHandler();
            return $handler->render($request, $exception);
        }
    }
}
