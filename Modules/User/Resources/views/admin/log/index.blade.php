@extends('admin::layout')

@component('admin::components.page.header')
    @slot('title', trans('user::permissions.log.index'))

    <li class="active">{{ trans('user::permissions.log.index') }}</li>
@endcomponent

@section('content')
    <div class="box box-primary">
        <div class="box-body index-table" id="log-table">
            @component('admin::components.table')
                @slot('thead')
                    <tr>
                        <th>Id</th>
                        <th>Action</th>
                        <th>Entity Name </th>
                        <th>Entity Id</th>
                        <th>User Name</th>
                        <th>Ip Address</th>
                        <th data-sort>{{ trans('admin::admin.table.created') }}</th>
                    </tr>
                @endslot
            @endcomponent
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        DataTable.setRoutes('#log-table .table', {
            index: '{{ "admin.log.index" }}',
        });

        new DataTable('#log-table .table', {
            columns: [
                { data: 'id' },
                { data: 'action' },
                { data: 'entity_name' },
                { data: 'entity_id' },
                { data: 'user.first_name' },
                { data: 'ip' },
                { data: 'created', name: 'created_at' },
            ],
        });
    </script>
@endpush
