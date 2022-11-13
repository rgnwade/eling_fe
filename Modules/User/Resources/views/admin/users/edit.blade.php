@extends('admin::layout')

@component('admin::components.page.header')
    @slot('title', trans('admin::resource.edit', ['resource' => trans('user::users.user')]))
    @slot('subtitle', $user->full_name)

    <li><a href="{{ route('admin.users.index') }}">{{ trans('user::users.users') }}</a></li>
    <li class="active">{{ trans('admin::resource.edit', ['resource' => trans('user::users.user')]) }}</li>
@endcomponent

@section('content')
    @if ($errors->any())
        {!! implode('', $errors->all('<div class="alert alert-danger" role="alert">
        <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
        :message
        </div>')) !!}
    @endif
    <form method="POST" action="{{ route('admin.users.update', $user) }}" class="form-horizontal" id="user-edit-form" novalidate>
        {{ csrf_field() }}
        {{ method_field('put') }}

        {!! $tabs->render(compact('user')) !!}
    </form>
@endsection

@include('user::admin.users.partials.shortcuts')
