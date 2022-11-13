@extends('admin::layout')

@component('admin::components.page.header')
    @slot('title', trans('product::products.product_request'))

    <li class="active">{{ trans('product::products.product_request') }}</li>
@endcomponent

@component('admin::components.page.index_table')
    @slot('resource', 'products')
    @slot('name', trans('product::products.product'))

    @slot('thead')
        <tr>
            @include('admin::partials.table.select_all', ['name' => 'products-index'])
            <th>{{ trans('product::products.table.thumbnail') }}</th>
            <th>{{ trans('product::products.table.seller') }}</th>
            <th>{{ trans('product::products.table.name') }}</th>
            <th>{{ trans('product::products.table.price') }}</th>
            <th>{{ trans('product::products.table.vendor_price') }}</th>
            <th>{{ trans('product::products.table.preview') }}</th>
            <th>{{ trans('admin::admin.table.status') }}</th>
            <th data-sort>{{ trans('admin::admin.table.updated') }}</th>
        </tr>
    @endslot
@endcomponent



@push('scripts')
    <script>
        keypressAction([
            { key: 'c', route: '{{ route("admin.products.create") }}'}
        ]);

        Mousetrap.bind('del', function () {
            $('{{ $selector ?? '' }} .btn-delete').trigger('click');
        });

        DataTable.setRoutes('#products-table .table', {
            index: '{{ "admin.products.index_vendor" }}',
            edit: '{{ "admin.products.edit_vendor" }}',
            destroy: '{{ "admin.products.destroy" }}',
        });
    </script>

    <script>
        new DataTable('#products-table .table', {
            columns: [
                { data: 'checkbox', orderable: false, searchable: false, width: '3%' },
                { data: 'thumbnail', orderable: false, searchable: false, width: '10%' },
                { data: 'company.name',  orderable: false, searchable: true },
                { data: 'name', name: 'translations.name', orderable: false, defaultContent: '' },
                { data: 'price', searchable: false },
                { data: 'vendor_price', searchable: false },
                { data: 'preview', searchable: false, orderable: false, },
                { data: 'status', name: 'is_active', searchable: false },
                { data: 'updated', name: 'updated_at' },
            ],
        });
    </script>
@endpush
