<?php

namespace Modules\Account\Http\Requests;

use Modules\Core\Http\Requests\Request;

class UpdateCompletionRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        return [
            'register_type' => 'required',
            'company.name' => 'required',
            'company.phone' => 'required|min:8|numeric',
            'company.address' => 'required',
            'company.email' => 'required|email:rfc',
            'company.director_name' => 'required_unless:register_type,customer',
            'company.director_passport' => 'required_unless:register_type,customer',
            'bank_account.beneficiary_bank' => 'nullable',
            'bank_account.beneficiary_name' => 'required_with:bank_account.beneficiary_bank',
            'bank_account.beneficiary_account' => 'required_with:bank_account.beneficiary_bank',
            'bank_account.swift_code' => 'required_with:bank_account.beneficiary_bank',
            'bank_account.bank_address' => 'required_with:bank_account.beneficiary_bank',
            'documents.npwp' => 'required_unless:register_type,international_merchant',
            'files.npwp' => 'required_unless:register_type,international_merchant',
            'documents.siup' => 'required_if:register_type,local_merchant',
            'files.siup' => 'required_if:register_type,local_merchant',
            'documents.nib'  => 'required_if:register_type,local_merchant',
            'documents.sppkp'  => 'required_if:is_tax_active,1',
            'documents.pajak'  => 'required_if:is_tax_active,1',
            'documents.akta'  => 'required_if:register_type,local_merchant',
            'files.nib'  => 'required_if:register_type,local_merchant',
            'files.sppkp'  => 'required_if:is_tax_active,1',
            'files.pajak'  => 'required_if:is_tax_active,1',
            'files.akta'  => 'required_if:register_type,local_merchant',
            'company.fta_status' => 'required',
            'company.fta_number' =>  'required_if:company.fta_status,==,1',
            'files.other_file' =>  'required_if:company.fta_status,==,1',

        ];
    }

    public function attributes()
    {
        return [
            'files.other_file' => trans('company::company.form.other_file'),
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
