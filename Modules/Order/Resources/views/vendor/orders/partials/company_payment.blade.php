<div class="order-information-wrapper">
    <h3 class="section-title">{{ trans('order::orders.payment_information') }}</h3>

    <div class="row">
        <div class="col-md-12">
            <div class="items-ordered">
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
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
