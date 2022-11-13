@extends('admin::layout')

@component('admin::components.page.header')
    @slot('title', trans('user::users.verification'))

    <li class="active">{{ trans('user::users.verification') }}</li>
@endcomponent

@component('admin::components.page.index_table')
    @slot('resource', 'verify')
    @slot('name', trans('user::users.verification'))

    @slot('thead')
        <tr>
            @include('admin::partials.table.select_all')

            <th>{{ trans('user::users.table.first_name') }}</th>
            <th>{{ trans('user::users.table.last_name') }}</th>
            <th>{{ trans('user::users.table.email') }}</th>
            <th>{{ trans('user::users.table.register_type') }}</th>
            <th>{{ trans('user::users.table.status') }}</th>
            <th data-sort>{{ trans('admin::admin.table.created') }}</th>
        </tr>
    @endslot
@endcomponent

@push('scripts')
    <script>
        new DataTable('#verify-table .table', {
            columns: [
                { data: 'checkbox', orderable: false, searchable: false, width: '3%' },
                { data: 'first_name', name: 'first_name' },
                { data: 'last_name', name: 'last_name' },
                { data: 'email', name: 'email' },
                { data: 'register_type', name: 'last_login', searchable: false },
                { data: 'register_status', name: 'chat_admin', searchable: false },
                { data: 'created', name: 'created_at' },
            ]
        });
    </script>
@endpush
