<?php

namespace Modules\Company\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class CompanyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'address' => $this->address,
            'email' => $this->email,
            'phone' => $this->phone,
            'director_name' => $this->director_name,
            'director_passport' => $this->director_passport,
            'country_id' => $this->country_id,
            'fta_status' => "".$this->fta_status."",
            'fta_number' => $this->fta_number,
            'is_tax_active' => $this->is_tax_active,
        ];
    }
}
