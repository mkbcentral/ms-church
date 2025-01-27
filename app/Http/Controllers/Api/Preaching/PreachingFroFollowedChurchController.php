<?php

namespace App\Http\Controllers\Api\Preaching;

use App\Exceptions\CustomExceptionHandler;
use App\Http\Controllers\Controller;
use App\Http\Resources\PreachingResource;
use App\Models\Preaching;
use Auth;
use Exception;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;

class PreachingFroFollowedChurchController extends Controller
{
    public  function preachings(Request $request)
    {
        try {
            $search = $request->input('search');
            // Obtenir les prêches liés aux églises suivies par l'utilisateur
            $query = Preaching::whereHas('church.followers', function ($query) use ($user) {
                $query->where('followers.user_id', Auth::id());
            });
            // Appliquer le filtre de recherche si le paramètre est présent
            if ($search) {
                $query->where(function ($subQuery) use ($search) {
                    $subQuery->where('title', 'like', '%' . $search . '%')
                        ->orWhere('preacher', 'like', '%' . $search . '%');
                });
            }
            $preachings = $query->orderBy('created_at', 'desc')
                ->get();

            return PreachingResource::collection($preachings);
        } catch (Exception $exception) {
            $handler = new CustomExceptionHandler();
            return $handler->render($request, $exception);
        }
    }
}
