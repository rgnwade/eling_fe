@extends('public.account.layout')

@section('title', trans('storefront::account.links.my_payments'))

@section('account_breadcrumb')
    <li class="active">{{ trans('storefront::account.links.my_payments') }}</li>
@endsection

@section('content_right')
    <div class="index-table">
        @if ($payments->isEmpty())
            <h3 class="text-center">{{ trans('storefront::account.payments.no_payments') }}</h3>
        @else
            <div class="table-responsive">
               <table class="table">
                   <thead>
                        <tr>
                            <th>{{ trans('storefront::account.orders.order_id') }}</th>
                            <th>{{ trans('storefront::account.payments.term') }}</th>
                            <th>{{ trans('storefront::account.payments.status') }}</th>
                            <th>{{ trans('storefront::account.payments.payment_method') }}</th>
                            <th>{{ trans('storefront::account.payments.total') }}</th>
                            <th>{{ trans('storefront::account.payments.remarks') }}</th>
                            <th>{{ trans('storefront::account.payments.action') }}</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($payments as $payment)
                        <tr>
                            <td>
                                <a href="{{ route('account.orders.show', $payment->order) }}" class="btn-view" data-toggle="tooltip"
                                    title="{{ trans('storefront::account.orders.view_order') }}" rel="tooltip">
                                     {{$payment->order->id}}
                                </a>
                            </td>
                            <td>{{ $payment->Type() }}</td>
                            <td>{{ $payment->status() }}</td>
                            <td>{{ $payment->payment_method_label}}</td>
                            <td>{{ $payment->amount->format() }}</td>
                            <td>{{ $payment->remarks }}</td>
                            <td>@if(!empty($payment->action()))
                                <a href="{{ $payment->action()['url'] }}"
                                    class="btn-sm btn-primary">{{ $payment->action()['title'] }}</a>
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
        @endif
    </div>


@endsection
