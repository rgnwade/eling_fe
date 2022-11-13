<div class="row">
    <div class="col-md-8">
        {{ Form::select('price_formula', trans('product::attributes.price_formula'), $errors, $product->priceFormulas(), $product, ['required' => true], trans('product::attributes.select_formula')) }}
        {{ Form::number('vendor_price', trans('product::attributes.vendor_price'), $errors, $product, ['min' => 0, 'required' => true, 'disabled' => true, 'readonly' => true]) }}
        {{ Form::text('vendor_currency', trans('product::attributes.vendor_currency'), $errors, $product, ['min' => 0, 'required' => true, 'disabled' => true, 'readonly' => true]) }}
        {{ Form::number('price', trans('product::attributes.price_idr'), $errors, $product, ['min' => 0, 'required' => true, 'disabled' => true, 'readonly' => true]) }}
        {{ Form::number('special_price', trans('product::attributes.special_price'), $errors, $product, ['min' => 0]) }}
        {{ Form::text('special_price_start', trans('product::attributes.special_price_start'), $errors, $product, ['class' => 'datetime-picker']) }}
        {{ Form::text('special_price_end', trans('product::attributes.special_price_end'), $errors, $product, ['class' => 'datetime-picker']) }}
    </div>
</div>
