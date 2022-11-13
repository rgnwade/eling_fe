<?php

namespace Modules\Account\Http\Requests;

use Modules\Core\Http\Requests\Request;

class InitCompletionRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        return [
            'company.name' => 'required',
            'company.phone' => 'required|min:8|numeric',
            'company.address' => 'required',
            'company.email' => 'required|email:rfc',
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
