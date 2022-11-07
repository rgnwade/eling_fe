{{ Form::text('name', trans('product::attributes.name'), $errors, $product, ['labelCol' => 2, 'required' => true]) }}
{{ Form::text('weight', trans('product::attributes.weight'), $errors, $product, ['labelCol' => 2, 'required' => true]) }}
{{ Form::wysiwyg('description', trans('product::attributes.description'), $errors, $product, ['labelCol' => 2, 'required' => true]) }}
{{ Form::wysiwyg('specification', trans('product::attributes.specification'), $errors, $product, ['labelCol' => 2, 'required' => false]) }}
<div class="row">
    <div class="col-md-8">
        {{ Form::select('categories', trans('product::attributes.categories'), $errors, $categories, $product, ['class' => 'selectize prevent-creation', 'multiple' => true]) }}
        {{ Form::select('tax_class_id', trans('product::attributes.tax_class_id'), $errors, $taxClasses, $product) }}
        {{ Form::checkbox('is_active', trans('product::attributes.is_active'), trans('product::products.form.enable_the_product'), $errors, $product) }}
        {{ Form::checkbox('is_lkpp', '', trans('product::attributes.is_lkpp'), $errors, $product) }}
        {{ Form::text('lkpp_id', trans('product::attributes.lkpp_id'), $errors, $product) }}
    </div>
</div>
