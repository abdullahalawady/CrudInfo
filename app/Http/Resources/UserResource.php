<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'token' => $this->token,
            'id' => $this->id,
            'username' => $this->user_name,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'image' => $this->image,
        ];
    }
}

