<button type="button" class="btn-close" data-dismiss="modal">
    &times;
</button>

<div class="quick-view clearfix">
    <div class="col-md-4 col-sm-7">
        <div class="quick-view-image">
            <div class="base-image">
                @if (! $product->base_image->exists)
                    <div class="image-placeholder">
                        <i class="fa fa-picture-o"></i>
                    </div>
                @else
                    <a class="base-image-inner" href="{{ $product->base_image->path }}">
                        <img src="{{ $product->base_image->path }}">

                        <span><i class="fa fa-search-plus" aria-hidden="true"></i></span>
                    </a>
                @endif

                @foreach ($product->additional_images as $additionalImage)
                    @if (! $additionalImage->exists)
                        <div class="image-placeholder">
                            <i class="fa fa-picture-o"></i>
                        </div>
                    @else
                        <a class="base-image-inner" href="{{ $additionalImage->path }}">
                            <img src="{{ $additionalImage->path }}">

                            <span><i class="fa fa-search-plus" aria-hidden="true"></i></span>
                        </a>
                    @endif
                @endforeach
            </div>

            <div class="additional-image">
                @if (! $product->base_image->exists)
                    <div class="image-placeholder">
                        <i class="fa fa-picture-o"></i>
                    </div>
                @else
                    <div class="thumb-image">
                        <img src="{{ $product->base_image->path }}">
                    </div>
                @endif

                @foreach ($product->additional_images as $additionalImage)
                    @if (! $additionalImage->exists)
                        <div class="image-placeholder">
                            <i class="fa fa-picture-o"></i>
                        </div>
                    @else
                        <div class="thumb-image">
                            <img src="{{ $additionalImage->path }}">
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>

    <div class="col-md-8 col-sm-12 col-xs-12">
        <div class="quick-view-details">
            <div class="product-details text-left">
                <h2 class="product-name"> {{ $product->merkName() }} {{ $product->name }}</h2>

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

                <h4 class="product-price pull-left">{{ product_price($product) }}</h4>
                <div class="availability pull-left">
                    <label>{{ trans('product::attributes.weight') }}:</label>
                    {{ $product->weight }}  Kg
                </div>

                <div class="availability pull-left">
                    <label>{{ trans('storefront::product.availability') }}:</label>

                    {{$product->stockProductStatus->name}}
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
                                <div class="col-sm-8 col-xs-10">
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
                    <form method="POST" action="{{ route('compare.store') }}">
                        {{ csrf_field() }}

                        <input type="hidden" name="product_id" value="{{ $product->id }}">

                        <button type="submit">{{ trans('storefront::product.add_to_compare') }}</button>
                    </form>

                    <form method="POST" action="{{ route('wishlist.store') }}">
                        {{ csrf_field() }}

                        <input type="hidden" name="product_id" value="{{ $product->id }}">

                        <button type="submit">{{ trans('storefront::product.add_to_wishlist') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
