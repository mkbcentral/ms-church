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
            'name'=>$this->name,
            'abbreviation'=>$this->abbreviation,
            'address'=>$this->address,
            'phone'=>$this->phone,
            'email'=>$this->email,
            'logo'=>$this->logo,
            'city'=>$this->city,
            'state'=>$this->state,
            'country'=>$this->country,
            'user'=>UserResource::make($this->user)
        ];
    }
}
