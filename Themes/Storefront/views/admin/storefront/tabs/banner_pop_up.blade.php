<div class="row">
    <div class="col-md-8">
        {{ Form::checkbox('storefront_banner_pop_up_enabled', trans('storefront::attributes.section_status'), trans('storefront::storefront.form.enable_banner_pop_up'), $errors, $settings) }}
    </div>
</div>

<div class="accordion-box-content">
    <div class="tab-content clearfix">
        <div class="banner-image-wrapper">
            @include('admin.storefront.tabs.partials.single_banner', [
                'label' => trans("storefront::storefront.form.banner"),
                'name' => 'storefront_banner_pop_up_banner',
            ])
        </div>
    </div>
</div>
