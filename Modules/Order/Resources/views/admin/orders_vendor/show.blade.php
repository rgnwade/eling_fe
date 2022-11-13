@extends('admin::layout')

@component('admin::components.page.header')
    @slot('title', trans('admin::resource.show', ['resource' => trans('order::orders.order')]).' : '.$order_id)

    <li><a href="{{ route('admin.orders.index') }}">{{ trans('order::orders.orders') }}</a></li>
    <li class="active">{{ trans('admin::resource.show', ['resource' => trans('order::orders.order')]) }}</li>
@endcomponent



@section('content')



@if ($errors->any())
    {!! implode('', $errors->all('<div class="alert alert-danger" role="alert">
        <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
        :message
    </div>')) !!}
@endif
    <div class="order-wrapper">
        <input type="hidden" value="{{ url('/') }}" id="url" />
       <h3>
        <br> Company  :  <a href="{{ route('admin.companies.edit', $vendor->id) }}" >{{ $vendor->name }}</a>
        <br> Order Id :  {{$order_id}}
        <br> Status :  {{ trans("order::vendor_statuses.{$company_order->status}")}}
        <br>
        <br>
       </h3>
        @include('order::admin.orders_vendor.partials.items_ordered')
         <br>
        @include('order::admin.orders_vendor.partials.payments_vendor')
        <br>
        @include('order::admin.orders_vendor.partials.modal_add_payment_vendor')
    </div>

@endsection
