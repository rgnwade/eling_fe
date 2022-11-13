@extends('admin::layout')

@component('admin::components.page.header')
    @slot('title', trans('admin::resource.show', ['resource' => trans('order::orders.order')]))

    <li><a href="{{ route('admin.orders.index') }}">{{ trans('order::orders.orders') }}</a></li>
    <li class="active">{{ trans('admin::resource.show', ['resource' => trans('order::orders.order')]) }}</li>
@endcomponent

@section('content')
    <div class="order-wrapper" id="app-show-order">
        @include('order::vendor.orders.partials.order_information')
        @include('order::vendor.orders.partials.items_ordered')
        @include('order::vendor.orders.partials.company_payment')
    </div>
@endsection
