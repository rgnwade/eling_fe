<?php

namespace Modules\Company\Http\Requests;

use Modules\Core\Http\Requests\Request;

class SaveCompanyRequest extends Request
{
    /**
     * Available attributes.
     *
     * @var string
     */
    protected $availableAttributes = 'company::attributes';

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'phone' => 'required|min:8|numeric',
            'phonecode' => 'required',
            'address' => 'required',
            'email' => 'required|email:rfc',
            'director_name' => 'required',
            'director_passport' => 'required',
            'type' => 'required',
            'beneficiary_bank' => 'nullable',
            'beneficiary_name' => 'required_with:beneficiary_bank',
            'beneficiary_account' => 'required_with:beneficiary_bank',
            'swift_code' => 'required_with:beneficiary_bank',
            'bank_address' => 'required_with:beneficiary_bank',
            'fta_number' =>  'required_if:fta_status,==,1',
            'files.other_file' =>  'required_if:fta_status,==,1',
            'npwp' => 'required_unless:type,international_merchant',
            'siup' => 'required_if:type,local_merchant',
            'nib'  => 'required_if:type,local_merchant',
            'sppkp'  => 'required_if:type,local_merchant',
            'pajak'  => 'required_if:type,local_merchant',
            'akta'  => 'required_if:type,local_merchant',
            'files.siup' => 'required_if:type,local_merchant',
            'files.npwp' => 'required_unless:type,international_merchant',
            'files.nib'  => 'required_if:type,local_merchant',
            'files.sppkp'  => 'required_if:type,local_merchant',
            'files.pajak'  => 'required_if:type,local_merchant',
            'files.akta'  => 'required_if:type,local_merchant',
        ];
    }

    public function attributes()
    {
        return [
            'files.other_file' => trans('company::company.form.other_file'),
        ];
    }
}
