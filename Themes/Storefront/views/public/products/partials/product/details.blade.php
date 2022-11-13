<div class="col-lg-8 col-md-7 col-sm-7 col-xs-12">
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
        <div class=" pull-left">
            <label>{{ trans('storefront::product.minimum_order') }}:</label>
             <span > {{$product->minimum_order}} </span>
        </div>


        <div class="clearfix"></div>
        @if (! is_null($product->short_description))
            <div class="product-brief">{{ $product->short_description }}</div>
        @endif

        <form method="POST" action="{{ route('cart.items.store') }}" class="clearfix">
            {{ csrf_field() }}

            <input type="hidden" name="product_id" value="{{ $product->id }}">

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
                <label class="pull-left" for="qty">{{ trans('storefront::product.qty') }}</label>

                <div class="input-group-quantity pull-left clearfix">
                    <input type="text" name="qty" value="{{$product->minimum_order}}" class="input-number input-quantity pull-left" id="qty" min="{{$product->minimum_order}}" max="{{ $product->manage_stock ? $product->qty : '' }}">

                    <span class="pull-left btn-wrapper">
                        <button type="button" class="btn btn-number btn-plus" data-type="plus"> + </button>
                        <button type="button" class="btn btn-number btn-minus" data-type="minus" disabled> &#8211; </button>
                    </span>
                </div>
            </div>

            <button type="submit" class="add-to-cart btn btn-primary pull-left" {{ $product->isOutOfStock() ? 'disabled' : '' }} data-loading>
                {{ trans('storefront::product.add_to_cart') }}
            </button>
        </form>

        <div class="clearfix"></div>

        <div class="add-to clearfix">
            <form method="POST" action="{{ route('wishlist.store') }}">
                {{ csrf_field() }}

                <input type="hidden" name="product_id" value="{{ $product->id }}">

                <button type="submit">{{ trans('storefront::product.add_to_wishlist') }}</button>
            </form>

            <form method="POST" action="{{ route('compare.store') }}">
                {{ csrf_field() }}

                <input type="hidden" name="product_id" value="{{ $product->id }}">

                <button type="submit">{{ trans('storefront::product.add_to_compare') }}</button>
            </form>
        </div>
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
