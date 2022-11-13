<?php

namespace Modules\Company\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class BankAccountResource extends JsonResource
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
            'beneficiary_bank' => $this->beneficiary_bank,
            'beneficiary_name' => $this->beneficiary_name,
            'beneficiary_account' => $this->beneficiary_account,
            'swift_code' => $this->swift_code,
            'bank_address' => $this->bank_address
        ];
    }
}
