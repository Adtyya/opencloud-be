<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CompanyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            "company_id" => $this->id,
            "page" => "company",
            "company_name" => $this->name,
            "website" => $this->website,
            "logo" => $this->logo,
            "employers" => EmployeResource::collection($this->whenLoaded('employe'))
        ];
    }
}
