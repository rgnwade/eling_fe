<div class="items-ordered-wrapper">
    <h3 class="section-title">{{ trans('order::orders.payment_list') }}</h3>

    <div class="row">
        <div class="col-md-12">
            <div class="items-ordered">
                <div class="table-responsive">
                    <table class="table">
                       <thead>
                        <tr>
                            <th>Id</th>
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
                            <td>{{ $payment->id }}</td>
                            <td>{{ $payment->Type() }}</td>
                            <td>{{ $payment->status() }}</td>
                            <td>{{ $payment->payment_method_label}}</td>
                            <td>{{ $payment->amount->format() }}</td>
                            <td>{{ $payment->remarks }}</td>
                            <td>
                                 @include('order::admin.orders.partials.modal_edit_payment', [
                                    'payment' => $payment,
                                    'payment_statuses' => $payment_statuses,
                                ])
                            </td>
                        </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
