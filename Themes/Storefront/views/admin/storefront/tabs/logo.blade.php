@include('media::admin.image_picker.single', [
    'title' => trans('storefront::storefront.form.favicon'),
    'inputName' => 'storefront_favicon',
    'file' => $favicon,
])

<div class="media-picker-divider"></div>

@include('media::admin.image_picker.single', [
    'title' => trans('storefront::storefront.form.header_logo'),
    'inputName' => 'translatable[storefront_header_logo]',
    'file' => $headerLogo,
])

<div class="media-picker-divider"></div>

@include('media::admin.image_picker.single', [
    'title' => trans('storefront::storefront.form.footer_logo'),
    'inputName' => 'translatable[storefront_footer_logo]',
    'file' => $footerLogo,
])

<div class="media-picker-divider"></div>

@include('media::admin.image_picker.single', [
    'title' => trans('storefront::storefront.form.mail_logo'),
    'inputName' => 'translatable[storefront_mail_logo]',
    'file' => $mailLogo,
])

<div class="media-picker-divider"></div>

@include('media::admin.image_picker.single', [
    'title' =>  trans('storefront::account.links.shipping_payment'),
    'inputName' => 'translatable[storefront_shipping_payment]',
    'file' => $shippingPayment,
])

<div class="media-picker-divider"></div>

@include('media::admin.image_picker.single', [
    'title' =>  'Certified',
    'inputName' => 'translatable[certified]',
    'file' => $certified,
])

