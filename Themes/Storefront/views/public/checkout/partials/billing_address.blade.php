<div class="billing-address clearfix">
    <h5>{{ trans("storefront::checkout.tabs.billing_address") }}</h5>
    <div class="col-md-6">
        <div class="form-group {{ $errors->has('billing.first_name') ? 'has-error': '' }}">
            <label for="billing-first-name">
                {{ trans('storefront::checkout.tabs.attributes.billing.first_name') }}<span>*</span>
            </label>

            <input type="text" name="billing[first_name]" value="{{  old('billing.first_name') ? old('billing.first_name') : ($last_order ?  $last_order->billing_first_name : '') }} " class="form-control" id="billing-first-name">

            {!! $errors->first('billing.first_name', '<span class="error-message">:message</span>') !!}
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group {{ $errors->has('billing.last_name') ? 'has-error': '' }}">
            <label for="billing-last-name">
                {{ trans('storefront::checkout.tabs.attributes.billing.last_name') }}<span>*</span>
            </label>

            <input type="text" name="billing[last_name]" value="{{  old('billing.last_name') ? old('billing.last_name') : ($last_order ?  $last_order->billing_last_name : '') }} " class="form-control" id="billing-last-name">

            {!! $errors->first('billing.last_name', '<span class="error-message">:message</span>') !!}
        </div>
    </div>

    <div class="col-md-12">
        <div class="form-group {{ $errors->has('billing.address_1') ? 'has-error': '' }}">
            <label for="billing-1">
                {{ trans('storefront::checkout.tabs.attributes.billing.address_1') }}<span>*</span>
            </label>

            <input type="text" name="billing[address_1]" value="{{  old('billing.address_1') ? old('billing.address_1') : ($last_order ?  $last_order->billing_address_1: '') }} " class="form-control" id="billing-address-1">

            {!! $errors->first('billing.address_1', '<span class="error-message">:message</span>') !!}
        </div>
    </div>

    <div class="col-md-12">
        <div class="form-group {{ $errors->has('billing.address_2') ? 'has-error': '' }}">
            <label for="billing-2">
                {{ trans('storefront::checkout.tabs.attributes.billing.address_2') }}
            </label>

            <input type="text" name="billing[address_2]" value="{{  old('billing.address_2') ? old('billing.address_2') : ($last_order ?  $last_order->billing_address_2: '') }} "  class="form-control" id="billing-address-2">

            {!! $errors->first('billing.address_2', '<span class="error-message">:message</span>') !!}
        </div>
    </div>

    <div class="col-md-12">
        <div class="form-group {{ $errors->has('billing.zip') ? 'has-error': '' }}">
            <label for="billing-zip">
                {{ trans('storefront::checkout.tabs.attributes.billing.zip') }}
            </label>

            <input type="text" name="billing[zip]" value="{{  old('billing.billing_zip') ? old('billing.zip') : ($last_order ?  $last_order->billing_zip: '') }} "  class="form-control" id="billing-zip">

            {!! $errors->first('billing.zip', '<span class="error-message">:message</span>') !!}
        </div>
    </div>

     <div class="col-md-6">
        <div class="form-group {{ $errors->has('billing.state') ? 'has-error': '' }}">
            <label for="billing-state">
                {{ trans('storefront::checkout.tabs.attributes.billing.state') }}<span>*</span>  <div v-if="loading" class="loading"></div>
            </label>
            <input name="billing[country]" type="hidden" value="ID">
            <input type="hidden" value="{{ url('/') }}" id="url" />
            <select v-model='state' @change='getCities()' name="billing[state]" required>
                <option value='' >{{ trans('storefront::checkout.select_state') }}</option>
                <option v-for='data in states' :value='data.province_id'>@{{ data.province }}</option>
            </select>

            {!! $errors->first('billing.state', '<span class="error-message">:message</span>') !!}
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group {{ $errors->has('billing.city') ? 'has-error': '' }}">
            <label for="billing-city">
                {{ trans('storefront::checkout.tabs.attributes.billing.city') }}<span>*</span>
            </label>

            <select v-model='city' @change='getDistricts()' name="billing[city]" required>
                <option value='' >{{ trans('storefront::checkout.select_city') }}</option>
                <option v-for='data in cities' :value='data.city_id'>@{{ data.city_name }}</option>
            </select>

            {!! $errors->first('billing.city', '<span class="error-message">:message</span>') !!}
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group {{ $errors->has('billing.district') ? 'has-error': '' }}">
            <label for="billing-district">
                {{ trans('storefront::checkout.tabs.attributes.billing.district') }}<span>*</span>
            </label>

            <select  v-model='district' @change='getCourier()' name="billing[district]">
                <option value='' >{{ trans('storefront::checkout.select_district') }}</option>
                <option v-for='data in districts' :value='data.subdistrict_id'>@{{ data.subdistrict_name }}</option>
            </select>

            {!! $errors->first('billing.district', '<span class="error-message">:message</span>') !!}
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group {{ $errors->has('billing.courier') ? 'has-error': '' }}">
            <label for="billing-courier">
                {{ trans('storefront::checkout.tabs.attributes.billing.courier') }}<span>*</span>
            </label>

            <select v-model='courier' @change='getCost()' name="billing[courier]">
                <option value='' >{{ trans('storefront::checkout.select_courier') }}</option>
                 <option v-for='data in couriers' :value='data.value'>@{{ data.text }}</option>
            </select>

            {!! $errors->first('billing.courier', '<span class="error-message">:message</span>') !!}
        </div>
    </div>

</div>
