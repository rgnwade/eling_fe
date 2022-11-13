@extends('admin::layout')

@component('admin::components.page.header')
@slot('title', trans('user::users.users'))

<li class="active">{{ trans('user::users.users') }}</li>
@endcomponent


@component('admin::components.page.index_table')
<div class="row">
    <div class="btn-group pull-right">
        <a href="{{ route("vendor.users.create") }}" class="btn btn-primary btn-actions btn-create pull-right">
            {{ trans("admin::resource.create", ['resource' => 'users']) }}
        </a>
    </div>
</div>

@slot('resource', 'users')



@slot('name', trans('user::users.user'))

<div class="table-responsive anchor-table">
    <table class="table">
        <thead>
            <tr>
                <td>{{trans('user::attributes.users.name')}}</td>
                <td>{{trans('user::attributes.users.email')}}</td>
                <td>{{trans('user::attributes.users.position')}}</td>
            </tr>
        </thead>
        <tbody>
            @forelse( Auth::user()->company->users as $user)
            <tr>
                <td>{{$user->fullname}}</td>
                <td>{{$user->email}}</td>
                <td>{{$user->position}}</td>

            </tr>
            @empty
            <tr>
                <td class="empty" colspan="5">{{ trans('admin::dashboard.no_data') }}</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="clearfix"></div>
@endcomponent
