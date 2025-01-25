<?php

namespace App\Http\Resources;

use App\Models\Church;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Church */
class ChurchResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'abbreviation' => $this->abbreviation,
            'phone' => $this->phone,
            'email' => $this->email,
            'logo' => $this->logo,
            'address' => $this->address,
            'city' => $this->city,
            'state' => $this->state,
            'country' => $this->country,
            'preaching_number' => $this->preachings->count(),
        ];
    }
}
