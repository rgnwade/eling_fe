<h3 class="section-title">{{ trans('order::orders.payments') }}</h3>
<div class="table-responsive">
    <table class="table">
        <thead>
            <tr>
                <th>{{ trans('order::orders.no') }}</th>
                <th>{{ trans('order::orders.date') }}</th>
                <th>{{ trans('order::orders.sender_bank') }}</th>
                <th>{{ trans('order::orders.beneficiary_bank') }}</th>
                <th>{{ trans('order::orders.amount') }}</th>
                <th>{{ trans('order::orders.remarks') }}</th>
                <th>{{ trans('order::orders.receipt') }}</th>
                <th>{{ trans('admin::admin.actions') }}</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($payments as $payment)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $payment->payment_date->format('d/m/Y')}}</td>
                <td>{!! $payment->sender_info !!}</td>
                <td>{!! $payment->beneficiary_info !!}</td>
                <td>{{ $payment->amount->format('usd') }}</td>
                <td>{{ $payment->remarks }}</td>
                <td><a href="{{ $payment->receipt->path}}" target="_blank">
                        <div class="image-holder">
                            <img src="{{ $payment->receipt->thumb }}">
                        </div>
                    </a>
                </td>
                <td> <form method="POST" action="{{ route('admin.order_payment_vendor.destroy', $payment->id) }}"  onsubmit="return confirm('{{ trans('order::orders.confirm_payment') }}');">
                        {{ csrf_field() }}
                        {{ method_field('delete') }}
                        <button type="submit" class="btn-danger btn-sm " data-toggle="tooltip"
                            title="{{ trans('storefront::account.wishlist.remove') }}">
                             {{ trans('admin::admin.buttons.delete') }}
                        </button>
                    </form>
                </td>

            </tr>
            @endforeach
        </tbody>
    </table>
</div>
