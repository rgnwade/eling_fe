@extends('admin::layout')

@component('admin::components.page.header')
    @slot('title', trans('company::company.companies'))

    <li class="active">{{ trans('company::company.companies') }}</li>
@endcomponent

@component('admin::components.page.index_table')
    @slot('buttons', ['create'])
    @slot('resource', 'companies')
    @slot('name', trans('company::company.company'))

    @slot('thead')
        <tr>
            @include('admin::partials.table.select_all')
            <th>{{ trans('company::company.table.name') }}</th>
            <th>{{ trans('company::company.table.country') }}</th>
            <th>{{ trans('company::company.table.address') }}</th>
            <th>{{ trans('company::company.table.type') }}</th>
            <th>{{ trans('company::company.table.status') }}</th>
        </tr>
    @endslot
@endcomponent

@push('scripts')
    <script>
        new DataTable('#companies-table .table', {
            columns: [
                { data: 'checkbox', orderable: false, searchable: false, width: '3%' },
                { data: 'name', name: 'name' },
                { data: 'country', name: 'country.name' },
                { data: 'address', name: 'address' },
                { data: 'type', name: 'type' },
                { data: 'status', name: 'is_active', searchable: false },
            ],
        });
    </script>
@endpush
