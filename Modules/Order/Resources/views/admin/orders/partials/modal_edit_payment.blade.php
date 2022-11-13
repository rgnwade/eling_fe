<button type="button" class="btn-sm btn-primary" data-toggle="modal" data-target="#edit-payment-{{$payment->id}}">
    {{ trans('order::orders.update_payment') }}
</button>

<div class="modal fade" id="edit-payment-{{$payment->id}}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    <i class="fa fa-times" aria-hidden="true"></i>
                </button>

                <h4 class="modal-title">{{ trans('order::orders.update_payment') }} {{$payment->id}} </h4>
            </div>
            <form method="POST" action="{{ route('admin.order_payment.update', $payment->id) }}">
                   {{ csrf_field() }}
                   {{ method_field('put') }}
                <div class="modal-body">

                    <div class="form-group">
                        <label class="col-form-label">{{trans('order::orders.total')}}</label>
                        <span class="form-control">{{ $payment->amount->format()}} </span>
                    </div>

                    <div class="form-group">
                        <label class="col-form-label">{{trans('order::payment_order.remarks')}}</label>
                        <input type="text" class="form-control" name="remarks" value="{{$payment->remarks}}"
                            placeholder="{{ trans('order::payment_order.remarks')}}">
                    </div>

                    <div class="form-group">
                        <label class="col-form-label">{{trans('order::payment_order.status')}}</label>
                        <select class="form-control" name="status">
                            @foreach ( $payment_statuses as $payment_status)
                            <option value="{{$payment_status}}"
                                {{ $payment_status == $payment->status ? 'selected' : '' }} {{$payment->status}}>
                                {{trans('order::payment_statuses.'.$payment_status)}}</option>
                            @endforeach
                        </select>
                    </div>

                </div>

                <div class="modal-footer">
                    {{ csrf_field() }}
                    <button type="button" class="btn btn-default cancel" data-dismiss="modal">
                        {{ trans('admin::admin.buttons.cancel') }}
                    </button>

                    <button type="submit" class="btn btn-danger delete">
                        {{ trans('admin::admin.buttons.save') }}
                    </button>

                </div>
            </form>
        </div>
    </div>
</div>
