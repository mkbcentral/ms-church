<?php

namespace App\Http\Controllers\Api\Church;

use App\Exceptions\CustomExceptionHandler;
use App\Http\Controllers\Controller;
use App\Http\Resources\ChurchResource;
use App\Models\Church;
use Exception;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

class ChurchesToFollowController extends Controller
{
    public function index(int $limit)
    {
        try {
            $query = Church::query()
                ->orderBy('created_at', 'desc')
                ->orderBy('name', 'asc');
            $search = request('search');
            // Appliquer le filtre de recherche si le paramètre est présent
            if ($search) {
                $query->where(function ($subQuery) use ($search) {
                    $subQuery->where('name', 'like', '%' . $search . '%')
                        ->orWhere('abbreviation', 'like', '%' . $search . '%');
                });
            }
            $churches = $query->limit($limit)->get();
            return response([
                'churches' => ChurchResource::collection($churches),
            ], Response::HTTP_OK);
        } catch (Exception $exception) {
            $handler = new CustomExceptionHandler();
            return $handler->render(request(), $exception);
        }
    }
}
