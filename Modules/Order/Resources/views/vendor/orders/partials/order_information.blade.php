@if ($errors->any())
{!! implode('', $errors->all('<div class="alert alert-danger" role="alert">
<a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
:message
</div>')) !!}
@endif
<div class="order-information-wrapper">
    <div class="order-information-buttons">

    </div>

    <h3 class="section-title">{{ trans('order::orders.order_and_account_information') }}</h3>

    <div class="row">
        <div class="col-md-6">
            <div class="order clearfix">
                <div class="table-responsive">
                    <form method="POST" action="{{ route('vendor.orders.update', $order->id) }}" class="form" id="company-edit-form" validate>
                        {{ csrf_field() }}
                        {{ method_field('put') }}
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td>{{ trans('order::orders.no_order') }}</td>
                                <td>{{ $order->id }}-{{$company_order->company_id}}</td>
                                </tr>

                                <tr>
                                    <td>{{ trans('order::orders.order_date') }}</td>
                                    <td>{{ $order->created_at->toFormattedDateString() }}</td>
                                </tr>

                                <tr>
                                    <td>{{ trans('order::orders.customer_name') }}</td>
                                    <td>{{ $order->customer_full_name }}</td>
                                </tr>

                                <tr>
                                    <td>{{ trans('order::orders.order_status') }}</td>

                                    <td>
                                        @if ($order->completed())
                                            {{ trans("order::statuses.completed") }}
                                        @else
                                            <div class="row">
                                                <div class="col-lg-9 col-md-10 col-sm-10">
                                                    {{ Form::selectVertical('status', '', $errors, trans('order::vendor_statuses'), $company_order) }}

                                                </div>
                                            </div>
                                        @endif
                                    </td>
                                </tr>


                                @if (is_multilingual())
                                <tr>
                                    <td>{{ trans('order::orders.currency') }}</td>
                                    <td>{{ $order->currency }}</td>
                                </tr>

                                <tr>
                                    <td>{{ trans('order::orders.currency_rate') }}</td>
                                    <td>{{ $order->currency_rate }}</td>
                                </tr>
                                @endif

                                @if (!$order->completed())
                                    <tr>
                                        <td></td>
                                        <td>
                                            <div class="row">
                                                <div class="col-lg-9 col-md-10 col-sm-10">
                                                    <button type="submit" value="Submit" class="btn btn-primary mr-auto">
                                                        {{ trans('admin::admin.buttons.save') }}
                                                    </button>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="account-information">
                <div class="table-responsive">
                    <table class="table">
                        <tbody>
                            <tr>
                            <td>{{ trans('order::orders.total') }}</td>
                                <td>{{ $company_order->formatted_total_vendor  }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
