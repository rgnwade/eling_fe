@extends('admin::layout')

@component('admin::components.page.header')
    @slot('title', trans('admin::resource.show', ['resource' => trans('order::orders.order')]))

    <li><a href="{{ route('admin.orders.index') }}">{{ trans('order::orders.orders') }}</a></li>
    <li class="active">{{ trans('admin::resource.show', ['resource' => trans('order::orders.order')]) }}</li>
@endcomponent

@section('content')
    <div class="order-wrapper" id="app-show-order">
        <input type="hidden" value="{{ url('/') }}" id="url" />
        @include('order::admin.orders.partials.order_and_account_information')
        @include('order::admin.orders.partials.address_information')
        @include('order::admin.orders.partials.items_ordered')
        @include('order::admin.orders.partials.order_totals')
        @include('order::admin.orders.partials.payment_list')
        @include('public.account.orders.resi_modal')
    </div>
    <script src="{{ v(Theme::url('public/js/app-show-order.js')) }}"></script>

@endsection
