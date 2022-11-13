<div class="row" id="app">
    <div class="col-md-8">
        {{ Form::text('name', trans('company::attributes.name'), $errors, $company, ['required' => true]) }}
        {{ Form::text('address', trans('company::attributes.address'), $errors, $company, ['required' => true]) }}
        {{-- {{ Form::select('country_id', trans('company::attributes.country'), $errors, $countries, $company, ['required' => true]) }}
        {{ Form::text('phone', trans('company::attributes.phone'), $errors, $company, ['required' => true]) }} --}}
        <div class="form-group ">
            <label for="country_id" class="col-md-3 control-label text-left"> {{trans('company::attributes.country')}}<span
                    class="m-l-5 text-red">*</span></label>
            <div class="col-md-9">
                <select name="country_id" id="country_id" class="form-control custom-select-black ">
                    <option value="">Select Country</option>
                    @foreach( $country_list as $country)
                    <option value="{{$country->id}}"
                         phonecode = '{{$country->phonecode}}' {{ old('country_id') == $country->id || $company->country_id == $country->id ? 'selected' : '' }} >{{$country->name}}
                    </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="form-group ">
            <label for="phone" class="col-md-3 control-label text-left">{{trans('company::attributes.phone')}}<span
                    class="m-l-5 text-red">*</span></label>
            <div class="col-md-2 " style="padding-right: 1px"><input name="phonecode" id="phonecode" type="text"  value="{{old('phonecode') ?: $company->phonecode }}"
                    class="form-control " placeholder="Code" readonly></div>
            <div class="col-md-7" style="padding-left: 1px"><input name="phone" id="phone" type="text" value="{{old('phone') ?: $company->phone }}"
                    class="form-control " placeholder="Phone Number" required></div>
        </div>


        {{ Form::text('email', trans('company::attributes.email'), $errors, $company, ['required' => true]) }}
        {{ Form::text('director_name', trans('company::attributes.director_name'), $errors, $company, ['required' => true]) }}
        {{ Form::text('director_passport', trans('company::attributes.director_passport'), $errors, $company, ['required' => true]) }}

        @if ($company->id)
            {{ Form::select('type', trans('company::attributes.type'), $errors, [
                'international_merchant' => trans('user::auth.international_merchant'),
                'local_merchant' => trans('user::auth.local_merchant'),
                'customer' => trans('user::auth.customer')
            ], $company, ['disabled' => true]) }}
        {{ Form::hidden('type', '', $errors, $company)}}
        @else
            {{ Form::select('type', trans('company::attributes.type'), $errors, [
                'international_merchant' => trans('user::auth.international_merchant'),
                'local_merchant' => trans('user::auth.local_merchant'),
                'customer' => trans('user::auth.customer')
            ], $company) }}
        @endif
        {{ Form::checkbox('is_seller', trans('company::attributes.is_seller'), trans('company::company.form.enable_as_seller'), $errors, $company) }}
        {{ Form::checkbox('is_buyer', trans('company::attributes.is_buyer'), trans('company::company.form.enable_as_buyer'), $errors, $company) }}
        {{ Form::checkbox('is_tax_active', trans('company::attributes.is_tax_active'), trans('company::company.form.enable_tax'), $errors, $company) }}
        {{ Form::checkbox('is_active', trans('company::attributes.is_active'), trans('company::company.form.enable_the_company'), $errors, $company) }}
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.js"></script>
<script>
    $( "#country_id" ).change(function() {
        let phonecode = $('option:selected', this).attr('phonecode');
        $( "#phonecode" ).val(phonecode);
        $( "#phone" ).focus();
    });
    let phonecode = $('#country_id option:selected').attr('phonecode');
    $( "#phonecode" ).val(phonecode);
</script>
