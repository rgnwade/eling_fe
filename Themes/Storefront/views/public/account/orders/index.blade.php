@extends('public.account.layout')

@section('title', trans('storefront::account.links.my_orders'))

@section('account_breadcrumb')
    <li class="active">{{ trans('storefront::account.links.my_orders') }}</li>
@endsection

@section('content_right')
    <div class="index-table" id="app-show-order">
        @include('public.account.orders.review_modal')
        <input type="hidden" value="{{ url('/') }}" id="url" />
        @if ($orders->isEmpty())
            <h3 class="text-center">{{ trans('storefront::account.orders.no_orders') }}</h3>
        @else
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>{{ trans('storefront::account.orders.order_id') }}</th>
                            <th>{{ trans('storefront::account.orders.date') }}</th>
                            <th>{{ trans('storefront::account.orders.status') }}</th>
                            <th>{{ trans('storefront::account.orders.total') }}</th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($orders as $order)
                            <tr>
                                <td>#{{ $order->id }}</td>
                                <td>{{ $order->created_at->toFormattedDateString() }}</td>
                                <td>{{ $order->status() }}</td>
                                <td>{{ $order->total->convert($order->currency, $order->currency_rate)->format($order->currency) }}</td>
                                <td>
                                    @if($order->completed())
                                        <a href="#" class="btn-view" data-toggle="modal" data-target="#post-review" data-target="#post-review"
                                        @click='getReviews({{ $order->id}})'>
                                            <i class="fa fa-comment" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Review"></i>
                                        </a>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('account.orders.show', $order) }}" class="btn-view" data-toggle="tooltip" title="{{ trans('storefront::account.orders.view_order') }}" rel="tooltip">
                                        <i class="fa fa-eye" aria-hidden="true"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

    @if ($orders->isNotEmpty())
        <div class="pull-right">
            {!! $orders->links() !!}
        </div>
    @endif
    <script src="{{ v(Theme::url('public/js/app-show-order.js')) }}"></script>
@endsection
