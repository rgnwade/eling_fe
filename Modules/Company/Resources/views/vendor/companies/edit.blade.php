@extends('admin::layout')

@component('admin::components.page.header')
@slot('title', trans('admin::resource.edit', ['resource' => trans('company::company.company')]))
@slot('subtitle', $company->name)

<li><a href="{{ route('admin.companies.index') }}">{{ trans('company::company.companies') }}</a></li>
<li class="active">{{ trans('admin::resource.edit', ['resource' => trans('company::company.company')]) }}</li>
@endcomponent

@section('content')
@if ($errors->any())
{!! implode('', $errors->all('<div class="alert alert-danger" role="alert">
    <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
    :message
</div>')) !!}
@endif
<form method="POST" action="{{ route('vendor.companies.update', $company) }}" class="form-vertical"
    id="company-edit-form" validate>
    {{ csrf_field() }}
    {{ method_field('put') }}

    <div class="accordion-content clearfix">
        <div class="accordion-box-content col-lg-12 col-md-6">
            <div class="tab-content">
                <h3 class="tab-content-title">{{trans('company::company.tabs.general')}}</h3>
                <div class="row">
                    <div class="col-lg-6 col-md-6 ">
                        {{ Form::textVertical('name', trans('company::attributes.name'), $errors, $company, ['required' => true]) }}
                        {{ Form::textVertical('address', trans('company::attributes.address'), $errors, $company, ['required' => true]) }}
                        {{-- {{ Form::textVertical('phone', trans('company::attributes.phone'), $errors, $company, ['required' => true]) }}
                        --}}
                        <div class="form-group ">
                            <label for="country_id" class="control-label text-left">
                                {{trans('company::attributes.country')}}<span class="m-l-5 text-red">*</span></label>
                            <select name="country_id" id="country_id" class="form-control custom-select-black ">
                                <option value="">Select Country</option>
                                @foreach( $country_list as $country)
                                <option value="{{$country->id}}" phonecode='{{$country->phonecode}}'
                                    {{ old('country_id') == $country->id || $company->country_id == $country->id ? 'selected' : '' }}>
                                    {{$country->name}}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        {{ Form::textVertical('email', trans('company::attributes.email'), $errors, $company, ['required' => true]) }}
                        {{ Form::hidden('type', '', $errors, $company)}}
                    </div>
                    <div class="col-lg-6 col-md-6 ">
                        {{ Form::textVertical('director_name', trans('company::attributes.director_name'), $errors, $company, ['required' => true]) }}
                        {{ Form::textVertical('director_passport', trans('company::attributes.director_passport'), $errors, $company, ['required' => true]) }}
                        {{-- {{ Form::selectVertical('country_id', trans('company::attributes.country'), $errors, $countries, $company, ['required' => true]) }}
                        --}}

                        <div class="form-group ">
                            <label for="phone"
                                class=" control-label text-left">{{trans('company::attributes.phone')}}<span
                                    class="m-l-5 text-red">*</span></label>
                            <div class="row">
                                <div class="col-lg-2 " style="padding-right: 1px"><input name="phonecode" id="phonecode"
                                        type="text" value="{{old('phonecode') ?: $company->phonecode }}"
                                        class="form-control " placeholder="Code" readonly=""></div>
                                <div class="col-lg-10" style="padding-left: 1px"><input name="phone" id="phone"
                                        type="text" value="{{old('phone') ?: $company->phone }}" class="form-control "
                                        placeholder="Phone Number" required=""></div>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
            <div class="tab-content">
                <h3 class="tab-content-title">{{trans('company::company.form.logo')}}</h3>
                <div class="row">
                    <div class="col-lg-12 col-md-12 ">
                        @include('media::vendor.image_picker.single', [
                        'title' => '',
                        'inputName' => 'files[base_image]',
                        'file' => $company->baseImage,
                        ])
                    </div>
                </div>
            </div>
            <div class="tab-content">
                <h3 class="tab-content-title">{{trans('company::company.form.gallery')}}</h3>
                <div class="row">
                    <div class="col-lg-12 col-md-12 ">
                        @include('media::vendor.image_picker.multiple', [
                        'title' => '',
                        'inputName' => 'files[additional_images][]',
                        'files' => $company->additionalImages,
                        ])
                    </div>
                </div>
            </div>
            <div class="tab-content">
                <h3 class="tab-content-title">{{trans('company::company.tabs.documents')}}</h3>

                @if($company->isLocalMerchantType())
                    @foreach ($docs as $doc)
                    <div class="col-lg-6 col-md-6 ">
                        {{ Form::textVertical($doc, trans('storefront::account.completion.'.$doc), $errors, $documents) }}
                        @include('media::vendor.file_picker.single_vertical', [
                            'title' => '',
                            'inputName' => 'files['.$doc.']',
                            'file' => $company->getAttachment($doc),
                        ])
                        @if($errors->has('files.'.$doc))
                            <div class="form-group has-error">
                                {!! $errors->first('files.'.$doc, '<span class="help-block">:message</span>') !!}
                            </div>
                        @endif
                    </div>
                    @endforeach
                @else
                    <div class="col-lg-12 col-md-12 ">
                        <small>{{trans('company::company.tabs.fta_remarks')}}</small>
                    </div>
                    <div class="col-lg-6 col-md-6 ">

                        {{ Form::selectVertical('fta_status', trans('company::attributes.fta_status'), $errors, [1 => 'FTA', 0 => 'NON-FTA'], $company) }}
                    </div>

                    <div class="col-lg-6 col-md-6 ">
                        {{ Form::textVertical('fta_number', trans('company::attributes.fta_number'), $errors, $company) }}
                    </div>

                    <div class="col-lg-12 col-md-12 ">
                        @include('media::vendor.file_picker.single_vertical', [
                        'title' => trans('company::company.form.other_file'),
                        'inputName' => 'files[other_file]',
                        'file' => $company->otherFile,
                        ])
                    </div>
                @endif


            </div>

            <div class="clearfix"></div>

            <div class="tab-content">
                <h3 class="tab-content-title">{{trans('company::company.tabs.info')}}</h3>
                <div class="col-lg-6 col-md-6 ">
                    {{ Form::textVertical('website', trans('company::attributes.website'), $errors, $company_info) }}
                    {{ Form::textVertical('twitter', trans('company::attributes.twitter'), $errors, $company_info) }}
                    {{ Form::textVertical('instagram', trans('company::attributes.instagram'), $errors, $company_info) }}
                    {{ Form::textVertical('facebook', trans('company::attributes.facebook'), $errors, $company_info) }}
                </div>
                <div class="col-lg-6 col-md-6 ">
                    {{ Form::wysiwygVertical('profile', trans('company::attributes.company_profile'), $errors, $company_info) }}
                </div>
            </div>

            <div class="tab-content">
                <h3 class="tab-content-title">{{trans('company::company.tabs.bank')}}</h3>
                <div class="col-lg-6 col-md-6 ">
                    {{ Form::textVertical('beneficiary_bank', trans('company::attributes.beneficiary_bank'), $errors, $company->bankAccount) }}
                    {{ Form::textVertical('beneficiary_name', trans('company::attributes.beneficiary_name'), $errors, $company->bankAccount) }}
                    {{ Form::textVertical('bank_address', trans('company::attributes.bank_address'), $errors, $company->bankAccount) }}
                </div>
                <div class="col-lg-6 col-md-6 ">
                    {{ Form::textVertical('beneficiary_account', trans('company::attributes.beneficiary_account'), $errors, $company->bankAccount) }}
                    {{ Form::textVertical('swift_code', trans('company::attributes.swift_code'), $errors, $company->bankAccount) }}

                </div>
            </div>

            {{-- <div class="tab-content">
                    <h3 class="tab-content-title">{{trans('company::company.tabs.users')}}</h3>
            <div class="col-lg-12 col-md-12 ">
                <div class="table-responsive anchor-table">
                    <table class="table">
                        <thead>
                            <tr>
                                <td>{{trans('company::company.tabs.name')}}</td>
                                <td>{{trans('company::company.tabs.email')}}</td>
                                <td>{{trans('company::company.tabs.action')}}</td>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($company->users as $user)
                            <tr>
                                <td>{{$user->fullname}}</td>
                                <td>{{$user->email}}</td>
                                <td> <a href="{{route('admin.users.edit', ['id' => $user->id])}}">
                                        {{trans('company::company.tabs.detail')}} </a></td>
                            </tr>
                            @empty
                            <tr>
                                <td class="empty" colspan="5">{{ trans('admin::dashboard.no_data') }}</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div> --}}
    </div>
    </div>

    <div class="modal-footer">
        <button type="submit" value="Submit" class="btn btn-primary mr-auto">
            {{ trans('admin::admin.buttons.save') }}
        </button>
    </div>
</form>
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
@endsection

@include('company::admin.companies.partials.scripts')
