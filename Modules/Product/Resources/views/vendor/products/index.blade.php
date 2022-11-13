@extends('admin::layout')

@component('admin::components.page.header')
    @slot('title', trans('product::products.products'))

    <li class="active">{{ trans('product::products.products') }}</li>
@endcomponent

@component('product::vendor.products.index_table')
    @slot('buttons', ['create'])
    @slot('resource', 'products')
    @slot('name', trans('product::products.product'))

    @slot('thead')
        @include('product::vendor.products.partials.thead', ['name' => 'products-index'])
    @endslot
@endcomponent

@push('scripts')
    <script>
        new DataTable('#products-table .table', {
            columns: [
                { data: 'checkbox', orderable: false, searchable: false, width: '3%' },
                { data: 'thumbnail', orderable: false, searchable: false, width: '10%' },
                { data: 'name', name: 'translations.name', orderable: false, defaultContent: '' },
                { data: 'vendor_price', searchable: false },
                { data: 'vendor_product_status.name', name: 'vendor_product_status', searchable: false, orderable: false },
                { data: 'created', name: 'created_at' },
            ],
        });
    </script>
@endpush
