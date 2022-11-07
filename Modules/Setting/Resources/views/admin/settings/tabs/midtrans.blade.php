<div class="row">
    <div class="col-md-8">
        {{ Form::checkbox('midtrans_enabled', trans('setting::attributes.midtrans_enabled'), trans('setting::settings.form.enable_midtrans'), $errors, $settings) }}
        {{ Form::text('translatable[midtrans_label]', trans('setting::attributes.midtrans_label'), $errors, $settings, ['required' => true]) }}
        {{ Form::textarea('translatable[midtrans_description]', trans('setting::attributes.midtrans_description'), $errors, $settings, ['rows' => 3, 'required' => true]) }}
    </div>
</div>
