<div id="payment" class="tab-pane" role="tabpanel">
    <div class="box-wrapper payment clearfix">

        <div class="box-header">
            <h4>{{ trans('storefront::checkout.tabs.payment.payment_terms') }}</h4>
        </div>

        <ul class="list-inline payment-method clearfix">
                <li>
                    <div class="form-group radio">
                        <input type="radio" name="payment_term"  @click='setFullPayment()' value="full_payment" id="full_payment"   {{ empty(old('payment_term')) ? 'checked' : '' }}  {{ old('payment_term') === 'full_payment' ? 'checked' : '' }}>
                        <label for="full_payment">  {{ trans('storefront::checkout.tabs.payment.full_payment') }}  <b id="total-amount2"> {{$cart->total()->convertToCurrentCurrency()->format()}} </b> </label>
                    </div>
                </li>
                 <li>
                    <div class="form-group radio">
                        <input type="radio" name="payment_term" @click='setadvancePayment()'  value="advance_payment" id="advancePayment"  {{ old('payment_term') === 'advancePayment' || $cart->hasPaymentTerm() ? 'checked' : '' }}>
                        <label for="advancePayment">  {{ trans('storefront::checkout.tabs.payment.advancePayment') }}  </label>
                    </div>
                     <p>30%  (Down Payment) : <b id="down_payment_amount_info"> {{ $cart->subTotalPercent(0.3)->format()}} </b> </p>
                     <p>70%  (Completion) :  <b id="completion_payment_amount_info">  {{ $cart->subTotalPercent(0.7)->format()}} </b> </p>
                </li>
            {!! $errors->first('payment_method', '<span class="error-message">:message</span>') !!}
        </ul>

         <div class="box-header">
            <h4>{{ trans('storefront::checkout.tabs.payment.payment_method') }}</h4>
        </div>

        <ul class="list-inline payment-method clearfix">
            @forelse ($gateways as $name => $gateway)
                <li>
                    <div class="form-group radio">
                        <input type="radio" name="payment_method" value="{{ $name }}" id="{{ $name }}" {{ $loop->first ? 'checked' : '' }} {{ old('payment_method') === $name ? 'checked' : '' }}>
                        <label for="{{ $name }}">{{ $gateway->label }}</label>
                    </div>

                    <p>{{ $gateway->description }}</p>
                </li>
            @empty
                <p class="error-message">{{ trans('storefront::checkout.tabs.payment.no_payment_method') }}</p>
            @endforelse

            {!! $errors->first('payment_method', '<span class="error-message">:message</span>') !!}
        </ul>

        <button type="button" class="btn btn-primary next-step pull-right" {{ $gateways->isEmpty() ? 'disabled' : '' }}>
            {{ trans('storefront::checkout.continue') }}
        </button>

        <button type="button" class="btn btn-default prev-step pull-right">
            {{ trans('storefront::checkout.back') }}
        </button>
    </div>
</div>
