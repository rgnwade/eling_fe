@extends('admin::layout')

@component('admin::components.page.header')
    @slot('title', trans('user::users.users'))

    <li class="active">{{ trans('user::users.users') }}</li>
@endcomponent

@component('admin::components.page.index_table')
    @slot('buttons', ['create'])
    @slot('resource', 'users')
    @slot('name', trans('user::users.user'))

    @slot('thead')
        <tr>
            @include('admin::partials.table.select_all')

            <th>{{ trans('user::users.table.first_name') }}</th>
            <th>{{ trans('user::users.table.last_name') }}</th>
            <th>{{ trans('user::users.table.email') }}</th>
            <th>{{ trans('user::users.table.last_login') }}</th>
            <th>{{ trans('user::users.table.roles') }}</th>
            <th>{{ trans('user::users.table.chat_admin') }}</th>
            <th data-sort>{{ trans('admin::admin.table.created') }}</th>
        </tr>
    @endslot
@endcomponent

@push('scripts')
    <script>
        new DataTable('#users-table .table', {
            columns: [
                { data: 'checkbox', orderable: false, searchable: false, width: '3%' },
                { data: 'first_name', name: 'first_name' },
                { data: 'last_name', name: 'last_name' },
                { data: 'email', name: 'email' },
                { data: 'last_login', name: 'last_login', searchable: false },
                { data: 'roles', name: 'roles', searchable: false },
                { data: 'chat_admin', name: 'chat_admin', searchable: false },
                { data: 'created', name: 'created_at' },
            ]
        });
    </script>
@endpush
