<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#add-payment">
    {{ trans('order::orders.add_payment') }}
</button>

<div class="modal fade" id="add-payment" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    <i class="fa fa-times" aria-hidden="true"></i>
                </button>

                <h3 class="modal-title">{{ trans('order::orders.add_payment') }}</h3>
            </div>
            <form method="POST" action="{{ route('admin.orders_vendor.store') }}">

                <div class="modal-body">
                    <div class="form-group">
                        <label class="col-form-label">{{trans('order::payment_order.payment_date')}} </label>

                        <div class="input-group date" data-provide="datepicker" data-date-format="dd/mm/yyyy">
                            <input type="text" class="form-control"
                                placeholder="{{ trans('order::payment_order.payment_date')}}" name="payment_date"
                                value="{{ date("d/m/Y")}}">
                            <div class="input-group-addon">
                                <span class="glyphicon glyphicon-th"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-lg-6">
                            <label class="col-form-label">{{trans('order::payment_order.amount')}}</label>
                            <input type="text" class="form-control" name="amount"
                                placeholder="{{ trans('order::payment_order.amount')}}">
                            <input type="hidden" name="order_id" value="{{$order->id}}">
                            <input type="hidden" name="company_id" value="{{$vendor->id}}">
                        </div>

                        <div class="form-group col-lg-6">
                            <label class="col-form-label">{{trans('order::payment_order.currency')}}</label>
                            <input type="text" class="form-control" name="currency" disabled
                                placeholder="{{ trans('order::payment_order.currency')}}" value="USD">
                        </div>
                    </div>

                    <legend>{{trans('order::payment_order.beneficiary')}}:</legend>
                    <div class="row">
                        <div class="form-group col-lg-6">
                            <label class="col-form-label">{{trans('order::payment_order.bank')}}</label>
                            <input type="text" class="form-control" name="beneficiary_bank" value="{{ $vendor->bankAccount->beneficiary_bank}}"
                                placeholder="{{trans('order::payment_order.beneficiary')}} {{ trans('order::payment_order.bank')}}">
                        </div>
                        <div class="form-group col-lg-6">
                            <label class="col-form-label">{{ trans('order::payment_order.swift_code')}}</label>
                            <input type="text" class="form-control" name="beneficiary_swift"  value="{{ $vendor->bankAccount->swift_code}}"
                                placeholder="{{trans('order::payment_order.beneficiary')}} {{ trans('order::payment_order.swift_code')}}">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-lg-6">
                            <label class="col-form-label">{{ trans('order::payment_order.name')}}</label>
                            <input type="text" class="form-control" name="beneficiary_name" value="{{  $vendor->bankAccount->beneficiary_name}}"
                                placeholder="{{trans('order::payment_order.beneficiary')}} {{ trans('order::payment_order.name')}}">
                        </div>
                        <div class="form-group col-lg-6">
                            <label class="col-form-label">{{ trans('order::payment_order.account')}}</label>
                            <input type="text" class="form-control" name="beneficiary_account" value="{{  $vendor->bankAccount->beneficiary_account}}"
                                placeholder="{{trans('order::payment_order.beneficiary')}} {{ trans('order::payment_order.account')}}">
                        </div>
                    </div>
                    </fieldset>

                    <fieldset>
                        <legend>{{trans('order::payment_order.sender')}}:</legend>
                        <div class="row">
                            <div class="form-group col-lg-6">
                                <label class="col-form-label">{{trans('order::payment_order.bank')}}</label>
                                <input type="text" class="form-control" name="sender_bank"
                                    placeholder="{{trans('order::payment_order.sender')}} {{ trans('order::payment_order.bank')}}">
                            </div>
                            <div class="form-group col-lg-6">
                                <label class="col-form-label">{{ trans('order::payment_order.swift_code')}}</label>
                                <input type="text" class="form-control" name="sender_swift"
                                    placeholder="{{trans('order::payment_order.sender')}} {{ trans('order::payment_order.swift_code')}}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-lg-6">
                                <label class="col-form-label">{{ trans('order::payment_order.name')}}</label>
                                <input type="text" class="form-control" name="sender_name"
                                    placeholder="{{trans('order::payment_order.sender')}} {{ trans('order::payment_order.name')}}">
                            </div>
                            <div class="form-group col-lg-6">
                                <label class="col-form-label">{{ trans('order::payment_order.account')}}</label>
                                <input type="text" class="form-control" name="sender_account"
                                    placeholder="{{trans('order::payment_order.sender')}} {{ trans('order::payment_order.account')}}">
                            </div>
                        </div>
                    </fieldset>

                    <div class="form-group">
                        <label class="col-form-label">{{trans('order::payment_order.remarks')}}</label>
                        <input type="text" class="form-control" name="remarks"
                            placeholder="{{ trans('order::payment_order.remarks')}}">
                    </div>

                    @include('media::admin.image_picker.single_only_upload', [
                    'title' => trans('order::payment_order.receipt'),
                    'inputName' => 'files[receipt]',
                    'file' => '',
                    ])

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
