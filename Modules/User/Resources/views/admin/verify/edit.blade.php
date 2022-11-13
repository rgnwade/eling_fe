@extends('admin::layout')

@component('admin::components.page.header')
@slot('title', trans('admin::resource.show', ['resource' => trans('user::users.verification')]))
@slot('subtitle', $user->full_name)

<li><a href="{{ route('admin.verify.index') }}">{{ trans('user::users.verification') }}</a></li>
<li class="active">{{ trans('admin::resource.show', ['resource' => trans('user::users.verification')]) }}</li>
@endcomponent

@section('content')
@if ($errors->any())
{!! implode('', $errors->all('<div class="alert alert-danger" role="alert">
    <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
    :message
</div>')) !!}
@endif

<div class="row">

    <div class="col-lg-6">
        <div class="clearfix">
            <h4 style="padding:10px 0px;">{{ trans('user::users.user') }}</h4>
            <table class="table">
                <tr>
                    <td>
                        {{ trans('user::attributes.users.register_type') }}
                    </td>
                    <td>
                        {{ trans('user::auth.'.$user->register_type) }}
                    </td>
                </tr>
                <tr>
                    <td>
                        {{ trans('user::attributes.users.status') }}
                    </td>
                    <td>
                        {{ $user->status }}
                    </td>
                </tr>
                <tr>
                    <td>
                        {{ trans('user::attributes.users.phone') }}
                    </td>
                    <td>
                        {{$user->phone }}
                    </td>
                </tr>

                <tr>
                    <td>
                        {{ trans('user::attributes.users.email') }}
                    </td>
                    <td>
                        {{$user->email }}
                    </td>
                </tr>

                <tr>
                    <td>
                        {{ trans('user::attributes.users.position') }}
                    </td>
                    <td>
                        {{ $user->position }}
                    </td>
                </tr>
            </table>
        </div>
    </div>
    
    <div class="col-lg-6">
        <div class="clearfix">
            <h4 style="padding:10px 0px;">{{ trans('storefront::account.completion.company') }}</h4>
            <table class="table">
                <tr>
                    <td>
                        {{ trans('company::attributes.name') }}
                    </td>
                    <td>
                        {{ $company->name }}
                    </td>
                </tr>
                <tr>
                    <td>
                        {{ trans('company::attributes.address') }}
                    </td>
                    <td>
                        {{ $company->address }}
                    </td>
                </tr>
                <tr>
                    <td>
                        {{ trans('company::attributes.country') }}
                    </td>
                    <td>
                        {{ $country->name }}
                    </td>
                </tr>
                <tr>
                    <td>
                        {{ trans('company::attributes.phone') }}
                    </td>
                    <td>
                        {{$country->phonecode}} {{ $company->phone }}
                    </td>
                </tr>

                <tr>
                    <td>
                        {{ trans('company::attributes.email') }}
                    </td>
                    <td>
                        {{ $company->email }}
                    </td>
                </tr>

                <tr>
                    <td>
                        {{ trans('company::attributes.director_name') }}
                    </td>
                    <td>
                        {{ $company->director_name }}
                    </td>
                </tr>

                <tr>
                    <td>
                        {{ trans('company::attributes.director_passport') }}
                    </td>
                    <td>
                        {{ $company->director_passport }}
                    </td>
                </tr>

                <tr>
                    <td>
                        {{ trans('company::attributes.fta_status') }}
                    </td>
                    <td>
                        {{ $company->fta_status == 1 ? 'FTA' : 'NON FTA'  }}
                    </td>
                </tr>

                <tr>
                    <td>
                        {{ trans('company::attributes.fta_number') }}
                    </td>
                    <td>
                        {{ $company->fta_number }}
                    </td>
                </tr>
            </table>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="clearfix">
            <h4 style="padding:10px 0px;">{{ trans('company::company.tabs.bank') }}</h4>
            <table class="table">
                <tr>
                    <td>
                        {{ trans('company::attributes.beneficiary_bank') }}
                    </td>
                    <td>
                        {{ $bank->beneficiary_bank }}
                    </td>
                </tr>
                <tr>
                    <td>
                        {{ trans('company::attributes.beneficiary_name') }}
                    </td>
                    <td>
                        {{ $bank->beneficiary_name }}
                    </td>
                </tr>
                <tr>
                    <td>
                        {{ trans('company::attributes.beneficiary_account') }}
                    </td>
                    <td>
                        {{ $bank->beneficiary_account }}
                    </td>
                </tr>
                <tr>
                    <td>
                        {{ trans('company::attributes.swift_code') }}
                    </td>
                    <td>
                        {{ $bank->swift_code }}
                    </td>
                </tr>
                <tr>
                    <td>
                        {{ trans('company::attributes.bank_address') }}
                    </td>
                    <td>
                        {{ $bank->bank_address }}
                    </td>
                </tr>
            </table>
        </div>
    </div>


    <div class="col-lg-6">
        <div class="clearfix">
            <h4 style="padding:10px 0px;">{{ trans('company::company.tabs.info') }}</h4>
            <table class="table">
                @foreach($socials as $social)
                <tr>
                    <td>
                        {{ trans('company::attributes.'.$social->title) }}
                    </td>
                    <td>
                        {{ $social->beneficiary_bank }}
                    </td>
                </tr>
                @endforeach
            </table>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="clearfix">
            <h4 style="padding:10px 0px;">{{ trans('company::company.tabs.documents') }}</h4>
            <table class="table">
                @foreach($documents as $document)
                <tr>
                    <td>
                        {{ trans('company::attributes.'.$document['title']) }}
                    </td>
                    <td>
                        {{ $document['value'] }}
                    </td>
                    @if ($document['ext'] == 'pdf')
                    <td>
                        <a href="{{ $document['path'] }}"> {{ $document['filename']}} </a>
                    </td>
                    <td></td>
                    @else
                    <td>
                        <a href="{{ $document['path'] }}"> {{ $document['filename']}} </a>
                    </td>
                    <td>
                        <img width=100px src="{{ $document['thumb'] }}">
                    </td>
                    @endif
                </tr>
                @endforeach
            </table>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-12">
        <form method="POST" action="{{ route('admin.verify.update', $user) }}" class="form" id="verify-edit-form"
            novalidate>
            {{ csrf_field() }}
            {{ method_field('put') }}

            <button type="submit" value="Submit" class="btn btn-primary mr-auto pull-right">
                {{ trans('user::auth.verified') }}</button>
    </div>



    </form>

</div>



@endsection

@include('user::admin.users.partials.shortcuts')
