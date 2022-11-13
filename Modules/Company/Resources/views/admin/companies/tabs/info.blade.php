<div class="row">
    <div class="col-md-8">
        {{ Form::text('website', trans('company::attributes.website'), $errors, $company_info, ['required' => false]) }}
        {{ Form::text('twitter', trans('company::attributes.twitter'), $errors, $company_info, ['required' => false]) }}
        {{ Form::text('instagram', trans('company::attributes.instagram'), $errors, $company_info, ['required' => false]) }}
        {{ Form::text('facebook', trans('company::attributes.facebook'), $errors, $company_info, ['required' => false]) }}
        {{ Form::wysiwyg('profile', trans('company::attributes.company_profile'), $errors, $company_info, ['required' => false]) }}
    </div>
</div>
