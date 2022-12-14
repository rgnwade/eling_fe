@extends('public.account.layout')

@section('title', trans('storefront::account.links.dashboard'))

@section('content_right')
    <div class="my-dashboard" id="app-show-order">
        @include('public.account.orders.review_modal')
        <input type="hidden" value="{{ url('/') }}" id="url" />

        @if(Auth::user()->isUnCompletedAccount())
            <div class="alert alert-danger" role="alert">
                <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
                {{ trans('account::messages.notification.uncompleted') }} <a href="{{ route('account.completion.index') }}"> Here </a>
            </div>
        @elseif(Auth::user()->isOnProcessVerification() && !Auth::user()->isCustomerB2CType())
        <div class="alert alert-warning" role="alert">
            <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
            {{ trans('account::messages.notification.onverification') }}
        </div>
        @endif


        <div class="recent-orders index-table">
            <h4 class="section-header">
                {{ trans('storefront::account.dashboard.recent_orders') }}

                @if ($recentOrders->isNotEmpty())
                    <a href="{{ route('account.orders.index') }}" class="pull-right">
                        {{ trans('storefront::account.dashboard.view_all') }}
                    </a>
                @endif
            </h4>

            @if ($recentOrders->isEmpty())
                <span>{{ trans('storefront::account.orders.no_orders') }}</span>
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
                            @foreach ($recentOrders as $order)
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

        <div class="clearfix"></div>

        <div class="account-information clearfix">
            <h4>{{ trans('storefront::account.dashboard.account_information') }}</h4>

            <div class="col-md-6">
                <div class="row">
                    <div class="contact-information">
                        <span>{{ $my->full_name }}</span>
                        <span>{{ $my->email }}</span>

                        <a href="{{ route('account.profile.edit') }}">
                            {{ trans('storefront::account.dashboard.edit') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ v(Theme::url('public/js/app-show-order.js')) }}"></script>

@endsection
