<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class userResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'nama' => $this->name,
            'email' => $this->email,
            'token' => $this->createToken('Token')->plainTextToken,
            'role' => $this->roles->pluck('name'),
            'permission' => $this->roles->pluck('permissions')->flatten()->pluck('name'),


        ];
    }
}
