{{ Form::text('name', trans('product::attributes.name'), $errors, $product, ['labelCol' => 2, 'required' => true]) }}
{{ Form::select('company_id', trans('product::attributes.seller'), $errors, $companies, $product, ['labelCol' => 2, 'disabled' => true, 'readonly' => true]) }}


@if($product->isVideotron())
{{ Form::number('weight', trans('product::admin.weight_meter'), $errors, $product, ['labelCol' => 2, 'required' => true]) }}
{{ Form::number('cabinet_depth', trans('product::admin.depth_meter'), $errors, $product, ['step'=>'0.01',  'required' => true, 'placeholder' => trans('product::vendor.depth_meter')]) }}
{{ Form::number('cabinet_length', trans('product::admin.length_meter'), $errors, $product, [ 'required' => true, 'placeholder' => trans('product::vendor.height')]) }}
{{ Form::number('cabinet_width', trans('product::admin.width_meter'), $errors, $product, [ 'required' => true, 'placeholder' => trans('product::vendor.width')]) }}

@else
{{ Form::number('weight', trans('product::attributes.weight'), $errors, $product, ['labelCol' => 2, 'required' => true]) }}
{{ Form::number('length', trans('product::attributes.length'), $errors, $product, ['labelCol' => 2, 'required' => false]) }}
{{ Form::number('height', trans('product::attributes.height'), $errors, $product, ['labelCol' => 2, 'required' => false]) }}
{{ Form::number('width', trans('product::attributes.width'), $errors, $product, ['labelCol' => 2, 'required' => false]) }}
@endif

{{ Form::number('minimum_order', trans('product::vendor.minimum_order'), $errors, $product, [ 'labelCol' => 2, 'required' => true]) }}
{{ Form::wysiwyg('description', trans('product::attributes.description'), $errors, $product, ['labelCol' => 2, 'required' => true]) }}
{{ Form::wysiwyg('specification', trans('product::attributes.specification'), $errors, $product, ['labelCol' => 2, 'required' => false]) }}
<div class="row">
    <div class="col-md-8">
        {{ Form::select('categories', trans('product::attributes.categories'), $errors, $categories, $product, ['class' => 'selectize prevent-creation', 'multiple' => true]) }}
        {{ Form::select('tax_class_id', trans('product::attributes.tax_class_id'), $errors, $taxClasses, $product) }}
        {{ Form::select('stock_product_status_id', trans('product::vendor.stock_status'), $errors, $stock_status, $product) }}
        {{ Form::checkbox('is_active', trans('product::attributes.is_active'), trans('product::products.form.enable_the_product'), $errors, $product) }}
         {{ Form::select('vendor_product_status_id', trans('product::vendor.vendor_status'), $errors, $vendor_status, $product) }}
        {{ Form::checkbox('is_lkpp', '', trans('product::attributes.is_lkpp'), $errors, $product) }}
        {{ Form::text('lkpp_id', trans('product::attributes.lkpp_id'), $errors, $product) }}
    </div>
</div>
