<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AuthResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $name = $this->name;
        return [
            "user_id" => $this->id,
            "name" => $name,
            "email" => $this->email,
            "role" => $this->role,
            "token" => $this->createToken($name)->plainTextToken
        ];
    }
}
