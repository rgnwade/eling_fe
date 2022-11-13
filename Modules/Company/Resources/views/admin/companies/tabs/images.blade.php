@include('media::admin.image_picker.single', [
    'title' => trans('company::company.form.logo'),
    'inputName' => 'files[base_image]',
    'file' => $company->baseImage,
])

<div class="media-picker-divider"></div>

@include('media::admin.image_picker.multiple', [
    'title' => trans('company::attributes.gallery'),
    'inputName' => 'files[additional_images][]',
    'files' => $company->additionalImages,
])
