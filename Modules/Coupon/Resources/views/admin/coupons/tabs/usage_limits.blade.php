<div class="row">
    <div class="col-md-8">
        {{ Form::number('usage_limit_per_coupon', trans('coupon::attributes.usage_limit_per_coupon'), $errors, $coupon) }}
        {{ Form::number('usage_limit_per_customer', trans('coupon::attributes.usage_limit_per_customer'), $errors, $coupon) }}
        {{ Form::checkbox('usage_only_for_new_customer', trans('coupon::attributes.usage_only_for_new_customer'), trans('coupon::attributes.usage_only_for_new_customer'), $errors, $coupon) }}
    </div>
    </div>
</div>
