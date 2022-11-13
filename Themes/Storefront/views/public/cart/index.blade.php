@extends('public.layout')

@section('title', trans('storefront::cart.cart'))

@push('meta')
    <meta name="cart-has-shipping-method" content="{{ $cart->hasShippingMethod() }}">
@endpush

@section('content')
    <div class="row" id="eling-cart">
        <div v-if="loading" class="loading"></div>
        <input type="hidden" value="{{ url('/') }}" id="url" />
        <div class="cart-list-wrapper clearfix">
            @if ($cart->isEmpty())
                <h2 class="text-center">{{ trans('storefront::cart.your_cart_is_empty') }}</h2>
            @else
                <div class="col-md-8">
                    <div class="box-wrapper clearfix">
                        <div class="box-header">
                            <h4>{{ trans('storefront::cart.cart') }}</h4>
                        </div>

                        <div class="cart-list">
                            <div class="table-responsive">
                                <table class="table">
                                    <tbody>
                                            <tr class="cart-item" v-for='item in cart_items'>
                                                <td>
                                                    <div class="image-holder" v-if="item.image != null">
                                                        <img :src="item.image" />
                                                    </div>
                                                    <div class="image-placeholder" v-else>
                                                        <i class="fa fa-picture-o" aria-hidden="true"></i>
                                                    </div>

                                                </td>

                                                <td>
                                                    <h5>
                                                        <a v-bind:href="item.slug">@{{ item.name }}</a>
                                                    </h5>

                                                    <div class="option" v-if="item.options.length > 0">
                                                        <div v-for="option in item.options">
                                                            <span>@{{ option.name }}:
                                                                <span> @{{ option.values.map(v => v.label).join(', ') }} </span>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </td>

                                                <td>
                                                    <label>{{ trans('storefront::cart.price') }}:</label>
                                                    <span>@{{ item.price }}</span>
                                                    <br>
                                                    <label>{{  trans('product::attributes.weight') }}:
                                                        @{{ item.weight }}  </label>
                                                </td>

                                                <td class="clearfix" >
                                                    <div class="quantity pull-left clearfix" >
                                                        
                                                        <div class="input-group-quantity pull-left clearfix" v-if="!item.isVideotron">
                                                            <input type="text" name="qty" v-bind:value="item.quantity" class="input-number input-quantity pull-left" min="1" :max="item.stock">

                                                            <span class="pull-left btn-wrapper">
                                                                <button type="button" class="btn btn-number btn-plus" @click='increaseQty(item.id)'> + </button>
                                                                <button type="button" class="btn btn-number btn-minus" @click='decreaseQty(item.id)' v-bind:disabled="isButtonDisabled(item)" > &#8211; </button>

                                                            </span>
                                                        </div>
                                                    </div>
                                                </td>

                                                <td>
                                                    <label v-if="item.isVideotron" >
                                                        Qty : @{{ item.details.width }} X @{{ item.details.length }} = @{{ item.quantity }} @{{ item.unit }} </label>
                                                        <br>
                                                    <label>{{ trans('storefront::cart.total') }}:</label>
                                                <span> @{{ item.subtotal }}</span>
                                                    <br>
                                                    <label>{{ trans('storefront::cart.weight_total') }}:</label>
                                                    <span>@{{ item.total_weight }}</span>
                                                </td>

                                                <td>
                                                    <button type="submit" @click='removeCartItem(item.id)' class="btn-close" data-toggle="tooltip" data-placement="top" title="{{ trans('storefront::cart.remove') }}">
                                                        &times;
                                                    </button>
                                                </td>
                                            </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="cart-list-bottom">
                            <div id="coupon-apply-form" class="clearfix">
                                <div class="form-group pull-left">
                                    <input type="text" name="coupon" class="form-control" id="coupon"  v-model="code">
                                    <button class="btn btn-primary" id="coupon-apply-submit" @click='redeemCoupon()'>
                                        {{ trans('storefront::cart.apply_coupon') }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="order-review cart-list-sidebar">
                        <div class="cart-total">
                            <h3>{{ trans('storefront::cart.cart_totals') }}</h3>

                            <span class="item-amount">
                                {{ trans('storefront::cart.subtotal') }}
                            <span id="cart-total">@{{ subtotal }}</span>
                            </span>

                            <span class="item-amount" v-if="coupon_code != '' && coupon_amount != ''">
                                {{ trans('storefront::cart.coupon') }} (<span class="coupon-code">@{{ coupon_code }}</span>)
                                <button @click='removeCoupon()' class="btn-close-coupon" data-toggle="tooltip" data-placement="left" title="{{ trans('storefront::cart.remove') }}">
                                    &times;
                                </button>
                                <span id="coupon-value">&#8211;@{{ coupon_amount }}</span>
                            </span>

                            @foreach ($cart->taxes() as $tax)
                                <span class="item-amount">
                                    {{ $tax->name() }}
                                    <span>{{ $tax->amount()->convertToCurrentCurrency()->format() }}</span>
                                </span>
                            @endforeach

                            <span class="item-amount">
                                {{ trans('storefront::cart.weight_total') }}
                                <span id='total-weight'>@{{ total_weight }}</span>
                            </span>

                            <span class="item-amount">
                                {{ trans('storefront::cart.shipping_total') }}
                                <span id="total-amount">@{{ this.shipping_cost }}</span>
                            </span>

                            <span class="total">
                                {{ trans('storefront::cart.total') }}
                                <span id="total-amount">@{{ this.total_amount }}</span>
                            </span>


                            @if ($cart->hasNoAvailableShippingMethod())
                                <span class="error-message text-center">{{ trans('storefront::cart.no_shipping_method_is_available') }}</span>
                            @endif

                            <a href="{{ route('checkout.create') }}" class="btn btn-primary btn-checkout {{ $cart->hasNoAvailableShippingMethod() ? 'disabled' : '' }}" data-loading>
                                {{ trans('storefront::cart.checkout') }}
                            </a>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>


    <script src="{{ v(Theme::url('public/js/cart-vue.js')) }}"></script>

    @include('public.products.partials.landscape_products', [
        'title' => trans('storefront::product.you_might_also_like'),
        'products' => $cart->crossSellProducts()
    ])
@endsection
