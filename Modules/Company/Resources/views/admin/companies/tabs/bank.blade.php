<div class="row">
    <div class="col-md-8">
        {{ Form::text('beneficiary_bank', trans('company::attributes.beneficiary_bank'), $errors, $company->bankAccount, ['required' => false]) }}
        {{ Form::text('beneficiary_name', trans('company::attributes.beneficiary_name'), $errors, $company->bankAccount, ['required' => false]) }}
        {{ Form::text('beneficiary_account', trans('company::attributes.beneficiary_account'), $errors, $company->bankAccount, ['required' => false]) }}
        {{ Form::text('swift_code', trans('company::attributes.swift_code'), $errors, $company->bankAccount, ['required' => false]) }}
        {{ Form::text('bank_address', trans('company::attributes.bank_address'), $errors, $company->bankAccount, ['required' => false]) }}
    </div>
</div>
