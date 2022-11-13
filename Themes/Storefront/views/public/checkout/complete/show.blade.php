@extends('public.layout')

@section('content')
    <section class="confirmation text-center">
        <i class="fa fa-check-circle-o" aria-hidden="true"></i>

        <h2>{{ trans('storefront::order_placed.your_order_has_been_placed') }}</h2>

        <p>
            {{ trans('storefront::order_placed.order_id') }} <a href="{{ route('account.orders.show', $order->id) }}"
                data-toggle="tooltip" title="{{ trans('storefront::account.orders.view_order') }}" rel="tooltip">

                <span> #{{ $order->id }} </a> </span>
            <br>
            {{ trans('storefront::order_placed.thanks') }}
        </p>
    </section>
@endsection
