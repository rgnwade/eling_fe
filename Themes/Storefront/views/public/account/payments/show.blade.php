@extends('public.layout')

@section('title', trans('storefront::account.view_order.view_order'))

@section('breadcrumb')
<li><a href="{{ route('account.dashboard.index') }}">{{ trans('storefront::account.links.my_account') }}</a></li>
<li><a href="{{ route('account.orders.index') }}">{{ trans('storefront::account.links.my_orders') }}</a></li>
<li class="active">{{ trans('storefront::account.orders.view_order') }}</li>
@endsection

@section('content')
<div class="orders-view-wrapper clearfix" id="app-show-order">
    <div class="row">
        <h3>Order ID : {{ $order->id }}</h3>

        <div class="col-md-6 col-sm-6">
            <div class="order-details">
                <div class="table-responsive">
                    <table class="table">
                        <tbody>
                            <tr>
                                <td>{{ trans('storefront::account.view_order.telephone') }}:</td>
                                <td>{{ $order->customer_phone ?: trans('storefront::account.view_order.n/a') }}</td>
                            </tr>

                            <tr>
                                <td>{{ trans('storefront::account.view_order.email') }}:</td>
                                <td>{{ $order->customer_email }}</td>
                            </tr>

                            <tr>
                                <td>{{ trans('storefront::account.view_order.date') }}:</td>
                                <td>{{ $order->created_at->toFormattedDateString() }}</td>
                            </tr>


                            <tr>
                                <td>{{ trans('order::orders.order_status') }}:</td>
                                <td>{{ $order->status()}}</td>
                            </tr>

                            <tr>
                                <td>{{ trans('storefront::account.view_order.payment_method') }}:</td>
                                <td>{{ $order->payment_method_label }}</td>
                            </tr>
                            @if($order->payment_method == 'midtrans' )
                            <tr>
                                <td>{{ trans('storefront::account.orders.payment_status') }}:</td>
                                <td>{{ $order->payment_status()}}</td>
                            </tr>
                            @endif

                            <tr>
                                <td>{{ trans('storefront::account.view_order.shipping_method') }}:</td>
                                <td>{{ $order->shipping_method }}</td>
                            </tr>

                            <input type="hidden" value="{{ url('/') }}" id="url" />

                            @if(!empty($order->no_resi))
                            <tr>
                                <td>{{ trans('order::orders.no_resi') }}</td>
                                <td>{{ $order->no_resi }} <a href="#" @click='getTracking("{{$order->id}}")'>
                                        {{ trans('storefront::account.orders.track') }} </a></td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-sm-6">
            <div class="order-address">
                <b> {{ trans('storefront::account.view_order.shipping_address') }}:</b>
                <span>{{ $order->shipping_full_name }}</span>
                <span>{{ $order->shipping_address_1 }}</span>
                <span>{{ $order->shipping_address_2 }}</span>
                <span>{{ $order->district }}, {{ $order->shipping_city }}, {{ $order->shipping_state }}</span>
                <span>{{ $order->shipping_country_name }}</span>
            </div>
        </div>
    </div>

    <div class="clearfix"></div>

    <div class="col-md-12 clearfix">
        <div class="row" style="margin-top: 30px;">
            <div class="table-responsive">
                <h4>{{ trans('storefront::account.view_order.payment_list') }}</h4>
                <table class="table" style="margin: 0 -8px;">
                    <thead>
                        <tr>
                            <th>Term</th>
                            <th>Status</th>
                            <th>Payment Method</th>
                            <th>Total</th>
                            <th>Remarks</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($order->payments as $payment)
                        <tr>
                            <td>{{ $payment->Type() }}</td>
                            <td>{{ $payment->status() }}</td>
                            <td>{{ $payment->payment_method_label}}</td>
                            <td>{{ $payment->amount->format() }}</td>
                            <td>{{ $payment->remarks }}</td>
                            <td>@if(!empty($payment->action()))
                                    <a href="{{ $payment->action()['url'] }}" class="btn-sm btn-primary">{{ $payment->action()['title'] }}</a>
                                @elseif(!empty($payment->instruction()))
                                    @include('public.account.orders.intruction_modal', [
                                    'payment_method' => $payment->payment_method,
                                    'title' => trans('storefront::checkout.tabs.confirm.payment_instructions'),
                                    'instruction' => $payment->instruction()
                                    ])
                                @else
                                    -
                                @endif


                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="row">
            <div class="cart-list">
                <div class="table-responsive">
                    <h4>{{ trans('storefront::account.view_order.order_details') }}</h4>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>{{ trans('storefront::account.view_order.product') }}</th>
                                <th>{{ trans('storefront::account.view_order.unit_price') }}</th>
                                <th>{{ trans('storefront::account.view_order.quantity') }}</th>
                                <th>{{ trans('storefront::account.view_order.line_total') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($order->products as $product)
                            <tr>
                                <td style="padding-top: 5px; padding-bottom: 5px;">
                                    <h5>
                                        <a href="{{ route('products.show', ['slug' => $product->slug]) }}">
                                            {{ $product->name }}
                                        </a>
                                    </h5>
                                    <div class="option">
                                        <span> {{  trans('product::attributes.weight') }}: <span>{{ $product->weight }}
                                                Kg</span></span>
                                        <span> {{ trans('storefront::cart.weight_total') }}
                                            <span>{{ $product->weight * intl_number($product->qty) }} Kg</span></span>

                                        @if ($product->hasAnyOption())
                                        @foreach ($product->options as $option)
                                        <span>{{ $option->name }}:
                                            <span>{{ $option->values->implode('label', ', ') }}</span></span>
                                        @endforeach
                                        @endif
                                    </div>
                                </td>

                                <td style="padding-bottom: 20px;">
                                    <label>{{ trans('storefront::account.view_order.unit_price') }}:</label>
                                    <span>{{ $product->unit_price->convert($order->currency, $order->currency_rate)->format($order->currency) }}</span>
                                </td>

                                <td style="color: #555555">
                                    <label>{{ trans('storefront::account.view_order.quantity') }}:</label>
                                    <span>{{ intl_number($product->qty) }}</span>
                                </td>
                                <td>
                                    <label>{{ trans('storefront::account.view_order.line_total') }}:</label>
                                    <span>{{ $product->line_total->convert($order->currency, $order->currency_rate)->format($order->currency) }}</span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="total-wrapper pull-right">
                <table class="table">
                    <tbody>
                        <tr>
                            <td>{{ trans('storefront::account.view_order.subtotal') }}</td>
                            <td>{{ $order->sub_total->convert($order->currency, $order->currency_rate)->format($order->currency) }}
                            </td>
                        </tr>
                        <tr>
                            <td>{{ trans('storefront::cart.shipping_total') }}</td>
                            <td>{{ $order->shipping_cost->convert($order->currency, $order->currency_rate)->format($order->currency) }}
                            </td>
                        </tr>

                        @if ($order->hasCoupon())
                        <tr>
                            <td>{{ trans('storefront::account.view_order.coupon') }} (<span
                                    class="coupon-code">{{ $order->coupon->code }}</span>)</td>
                            <td>&#8211;{{ $order->discount->convert($order->currency, $order->currency_rate)->format($order->currency) }}
                            </td>
                        </tr>
                        @endif

                        @foreach ($order->taxes as $tax)
                        <tr>
                            <td>{{ $tax->name }}</td>
                            <td>{{ $tax->order_tax->amount->convert($order->currency, $order->currency_rate)->format($order->currency) }}
                            </td>
                        </tr>
                        @endforeach
                        <td> {{ trans('storefront::cart.weight_total') }}</td>
                        <td> {{ $order->weight_total }} Kg</td>
                        <tr>
                        </tr>

                        <tr>
                            <td>{{ trans('storefront::account.view_order.total') }}</td>
                            <td>{{ $order->total->convert($order->currency, $order->currency_rate)->format($order->currency) }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    @include('public.account.orders.resi_modal')

</div>




<script src="{{ v(Theme::url('public/js/app-show-order.js')) }}"></script>
@endsection
