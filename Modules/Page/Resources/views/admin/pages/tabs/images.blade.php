@include('media::admin.image_picker.single', [
    'title' => trans('product::products.form.base_image'),
    'inputName' => 'files[base_image]',
    'file' => $page->baseImage,
])

<div class="media-picker-divider"></div>


