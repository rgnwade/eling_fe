@extends('admin::layout')

@section('title', trans('admin::resource.edit', ['resource' => trans('user::users.profile')]))

@component('admin::components.page.header')
    @slot('title', trans('admin::resource.edit', ['resource' => trans('user::users.profile')]))

    <li class="active">{{ trans('admin::resource.edit', ['resource' => trans('user::users.profile')]) }}</li>
@endcomponent

@section('content')
    @if ($errors->any())
        {!! implode('', $errors->all('<div class="alert alert-danger" role="alert">
        <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
        :message
        </div>')) !!}
    @endif
    <form method="POST" action="{{ route('vendor.profile.update') }}" class="form-horizontal" id="profile-form" novalidate>
        {{ csrf_field() }}
        {{ method_field('put') }}

        {!! $tabs->render() !!}
    </form>
@endsection
