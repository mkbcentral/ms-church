<?php

namespace App\Http\Resources;

use App\Models\Preaching;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Preaching */
class PreachingResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'audio_url' => $this->audio_url,
            'preacher' => $this->preacher,
            'cover_url' => $this->cover_url,
            'color' => $this->color,
            'church' => ChurchResource::make($this->church)
        ];
    }
}
