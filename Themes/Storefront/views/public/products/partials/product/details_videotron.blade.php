<div class="col-lg-8 col-md-7 col-sm-7 col-xs-12" id="product-detail">
    <input type="hidden" value="{{ url('/') }}" id="url" />
    <input type="hidden" value="{{ $product->videotronInfo->cabinet_width }}" id="cabinet_width" />
    <input type="hidden" value="{{ $product->videotronInfo->cabinet_length }}" id="cabinet_length" />
    <input type="hidden" value="{{ $product->minimum_order }}" id="minimum_order" />
    <div class="product-details">
        <h1 class="product-name">{{$product->merkName()}} {{ $product->name }}</h1>

        @if (setting('reviews_enabled'))
            @include('public.products.partials.product.rating', ['rating' => $product->avgRating()])

            <span class="product-review">
                ({{ intl_number($product->reviews->count()) }} {{ trans('storefront::product.customer_reviews') }})
            </span>
        @endif

        @unless (is_null($product->sku))
            <div class="sku">
                <label>{{ trans('storefront::product.sku') }}: </label>
                <span>{{ $product->sku }}</span>
            </div>
        @endunless

        @if ($product->manage_stock)
            <span class="left-in-stock">
                {{ trans('storefront::product.only') }}
                <span class="{{ $product->qty > 0 ? 'green' : 'red' }}">{{ intl_number($product->qty) }}</span>
                {{ trans('storefront::product.left') }}
            </span>
        @endif

        <div class="clearfix"></div>

        <span class="product-price pull-left">{{ product_price($product) }}</span>
         <div class="availability pull-left">
            <label>{{ trans('product::attributes.weight') }}:</label>
           {{ $product->weight }}  Kg
        </div>

        <div class="availability pull-left">
            <label>{{ trans('storefront::product.availability') }}:</label>
             <span >{{$product->stockProductStatus->name}}</span>
        </div>
        <div class="clearfix"></div>
        <div class=" pull-left">
            <label>{{ trans('storefront::product.seller') }}:</label>
            <span>
                @if (Auth::user())
                    <a href="{{ route('merchants.index', ['slug' => $product->company->slug]) }}">
                        {{ $product->company->name }}
                    </a>,
                        {{$product->company->country->name}}
                @else
                    @if($product->company->id != 1)
                        {{ trans('storefront::storefront.authorized_partner') }}
                    @else
                        {{ $product->company->name }}
                    @endif
                @endif
            </span>
        </div>
        <div class="clearfix"></div>
        
       <div class=" pull-left" style="padding-top: 10px">
            <p> {{ trans('storefront::product.enter_size') }} </p>
            <table>
                <tr>
                    <td width="150px"> <label>{{trans('storefront::product.check_size') }} </label> </td>
                    <td><input placeholder="width (m2)" style="width: 100px; text-align:center" v-model="customer_width"
                            type="number" step="{{ $product->videotronInfo->cabinet_width }}" min="0">
                        X
                        <input placeholder="length (m2)" style="width: 100px; text-align:center" v-model="customer_length"
                            type="number" step="{{ $product->videotronInfo->cabinet_length }}" min="0"> </td>
                </tr>
                <tr>
                    <td> &nbsp;</td>
                </tr>
                <tr>
                    <td> <label>{{trans('storefront::product.size_available') }}  </label> </td>
                    <td>
                        <b v-if="recommendedSize > 0">@{{recommended_width}} x @{{recommended_length}} = @{{recommendedSize}} m2
                        </b>
                    </td>
                </tr>
            </table>
        </div>
        <div class="clearfix"></div>
        <div class=" pull-left" style="padding-top: 10px">
            <label>{{ trans('storefront::product.minimum_order') }}:</label>
             <span > {{$product->minimum_order}} {{$product->unit}} </span>
        </div>



        <div class="clearfix"></div>
        @if (! is_null($product->short_description))
            <div class="product-brief">{{ $product->short_description }}</div>
        @endif

        <form method="POST" action="{{ route('cart.items.store') }}" class="clearfix">
            {{ csrf_field() }}

            <input type="hidden" name="product_id" value="{{ $product->id }}">
            <input type="hidden" id="recommended_width" name="details[width]">
            <input type="hidden" id="recommended_length" name="details[length]">
            <div class="product-variants clearfix">
                @foreach ($product->options as $option)
                    <div class="row">
                        <div class="col-md-7 col-sm-9 col-xs-10">
                            @includeIf("public.products.partials.product.options.{$option->type}")
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="quantity pull-left clearfix">
            <label class="pull-left" for="qty">{{ trans('storefront::product.qty') }} ({{$product->unit}})</label>

                <div class="input-group-quantity pull-left clearfix">
                    <input type="text" name="qty" class="input-quantity pull-left" id="qty" :value="recommendedSize" readonly >
                </div>
            </div>

            <button type="submit" :disabled="!canAddcart" class="add-to-cart btn btn-primary pull-left" {{ $product->isOutOfStock() ? 'disabled' : '' }} data-loading>
                {{ trans('storefront::product.add_to_cart') }}
            </button>
        </form>

        <div class="clearfix"></div>

        @auth
            @if (!empty($chat) && $chat['user']['is_seller'] == false)
                <div class="add-to clearfix">
                    <button type="submit" id="chat-button" class="btn btn-primary pull-left" onclick="loadGroupChatWithContext(
                        '{{$chat['client_group_id']}}',
                        '{{$chat['group_name']}}',
                        {{json_encode($chat['company'])}},
                        {{json_encode($chat['user'])}},
                        {{json_encode($chat['icon'])}},
                        {{json_encode($context)}},
                        )"
                    data-loading>{{ trans('storefront::product.chat_with_seller') }} <i
                    class="fa fa-comment "></i></button>
                </div>
            @endif
        @endauth
    </div>
</div>

<script src="{{ v(Theme::url('public/js/product-detail-vue.js')) }}"></script>
