{{ Form::text('name', trans('product::attributes.name'), $errors, $product, ['labelCol' => 2, 'required' => true]) }}
{{ Form::select('company_id', trans('product::attributes.seller'), $errors, $companies, $product, ['labelCol' => 2, 'disabled' => true, 'readonly' => true]) }}
{{ Form::number('weight', trans('product::attributes.weight'), $errors, $product, ['labelCol' => 2, 'required' => true]) }}
{{ Form::number('length', trans('product::attributes.length'), $errors, $product, ['labelCol' => 2, 'required' => false]) }}
{{ Form::number('height', trans('product::attributes.height'), $errors, $product, ['labelCol' => 2, 'required' => false]) }}
{{ Form::number('width', trans('product::attributes.width'), $errors, $product, ['labelCol' => 2, 'required' => false]) }}
{{ Form::number('minimum_order', trans('product::vendor.minimum_order'), $errors, $product, [ 'labelCol' => 2, 'required' => true]) }}
{{ Form::wysiwyg('description', trans('product::attributes.description'), $errors, $product, ['labelCol' => 2, 'required' => true]) }}
{{ Form::wysiwyg('specification', trans('product::attributes.specification'), $errors, $product, ['labelCol' => 2, 'required' => false]) }}
<div class="row">
    <div class="col-md-8">
        {{ Form::select('categories', trans('product::attributes.categories'), $errors, $categories, $product, ['class' => 'selectize prevent-creation', 'multiple' => true]) }}
        {{ Form::select('tax_class_id', trans('product::attributes.tax_class_id'), $errors, $taxClasses, $product) }}
        {{ Form::select('stock_product_status_id', trans('product::vendor.stock_status'), $errors, $stock_status, $product) }}
        {{ Form::checkbox('is_active', trans('product::attributes.is_active'), trans('product::products.form.enable_the_product'), $errors, $product) }}
        {{ Form::checkbox('is_lkpp', '', trans('product::attributes.is_lkpp'), $errors, $product) }}
        {{ Form::text('lkpp_id', trans('product::attributes.lkpp_id'), $errors, $product) }}
    </div>
</div>
