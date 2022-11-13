@extends('admin::layout')

@component('admin::components.page.header')
@slot('title', trans('admin::resource.create', ['resource' => trans('user::users.user')]))

<li><a href="{{ route('admin.users.index') }}">{{ trans('user::users.users') }}</a></li>
<li class="active">{{ trans('admin::resource.create', ['resource' => trans('user::users.user')]) }}</li>
@endcomponent

@section('content')
@if ($errors->any())
        {!! implode('', $errors->all('<div class="alert alert-danger" role="alert">
        <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
        :message
        </div>')) !!}
    @endif
<form method="POST" action="{{ route('vendor.users.store') }}" class="form-horizontal" id="user-create-form" novalidate>
    {{ csrf_field() }}

    <div class="row">
        <div class="col-md-12">
            {{ Form::text('first_name', trans('user::attributes.users.first_name'), $errors, $user, ['required' => true]) }}
            {{ Form::text('last_name', trans('user::attributes.users.last_name'), $errors, $user, ['required' => true]) }}
            {{ Form::email('email', trans('user::attributes.users.email'), $errors, $user, ['required' => true]) }}
            {{ Form::text('position', trans('user::attributes.users.position'), $errors, $user, ['required' => true]) }}
            {{ Form::password('password', trans('user::attributes.users.password'), $errors, null, ['required' => true]) }}
            {{ Form::password('password_confirmation', trans('user::attributes.users.password_confirmation'), $errors, null, ['required' => true]) }}
            <div class="form-group ">
                <label class="col-md-3"></label>
                <div class="col-md-9" style="font-size : 10px">
                    {{ trans('core::validation.regex_password')}}
                </div>
            </div>
        </div>

    </div>
    <div class="row">
        <div class="col-md-12">
            <button type="submit" value="Submit" class="btn btn-primary mr-auto pull-right">
                {{ trans('admin::admin.buttons.save') }}</button>
        </div>
    </div>

</form>
@endsection

@include('user::admin.users.partials.shortcuts')
