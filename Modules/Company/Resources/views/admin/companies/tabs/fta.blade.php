<div class="row">
    <div class="col-md-8">

        @if ($company->id && ($company->isLocalMerchantType() || $company->isCustomerType() ))
            @foreach ($docs as $doc)
                {{ Form::text($doc, trans('storefront::account.completion.'.$doc), $errors, $documents) }}
                @include('media::admin.file_picker.single', [
                    'title' => '',
                    'inputName' => 'files['.$doc.']',
                    'file' => $company->getAttachment($doc),
                ])
            @endforeach
        @else
            <div class="form-group ">
                <div class="col-md-12"> <small>{{trans('company::company.tabs.fta_remarks')}}</small></div>
            </div>

            {{ Form::select('fta_status', trans('company::attributes.fta_status'), $errors, [1 => 'FTA', 0 => 'NON-FTA'], $company) }}
            {{ Form::text('fta_number', trans('company::attributes.fta_number'), $errors, $company) }}

            @include('media::admin.file_picker.single', [
                'title' => trans('company::company.form.other_file'),
                'inputName' => 'files[other_file]',
                'file' => $company->otherFile,
            ])
        @endif
    </div>
</div>
