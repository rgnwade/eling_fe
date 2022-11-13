<?php

namespace Modules\Order\Http\Requests;

use Modules\Core\Http\Requests\Request;


class StoreOrderCompanyPaymentRequest extends Request
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'amount' => 'required|integer',
        ];
    }
}
