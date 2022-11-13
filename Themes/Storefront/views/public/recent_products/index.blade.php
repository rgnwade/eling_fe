@extends('public.layout')

@section('title')
    @if (request()->has('query'))
        {{ trans('storefront::products.search_results_for') }}: "{{ request('query') }}"
    @else
        Product Terbaru
    @endif
@endsection

@section('content')
    <section class="product-list">
        <div class="row">
           
            <div class="col-md-12 col-sm-12">
                <div class="product-list-header clearfix">
                    <div class="search-result-title pull-left">
                        <h3> Product Terbaru </h3>

                        <span>{{ intl_number($products->total()) }} {{ trans_choice('storefront::products.products_found', $products->total()) }}</span>
                    </div>

                    <div class="search-result-right pull-right">
                        <ul class="nav nav-tabs">
                            <li class="view-mode {{ ($viewMode = request('viewMode', 'grid')) === 'grid' ? 'active' : '' }}">
                                <a href="{{ $viewMode === 'grid' ? '#' : request()->fullUrlWithQuery(['viewMode' => 'grid']) }}" title="{{ trans('storefront::products.grid_view') }}">
                                    <i class="fa fa-th-large" aria-hidden="true"></i>
                                </a>
                            </li>

                            <li class="view-mode {{ $viewMode === 'list' ? 'active' : '' }}">
                                <a href="{{ $viewMode === 'list' ? '#' : request()->fullUrlWithQuery(['viewMode' => 'list']) }}" title="{{ trans('storefront::products.list_view') }}">
                                    <i class="fa fa-th-list" aria-hidden="true"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                
                <div class="clearfix"></div>

                <div class="product-list-result clearfix">
                    <div class="tab-content">
                        <div id="grid-view" class="tab-pane {{ ($viewMode = request('viewMode', 'grid')) === 'grid' ? 'active' : '' }}">
                            <div class="row">
                                <div class="grid-products separator">
                                    @if ($viewMode === 'grid')
                                        @forelse ($products as $product)
                                            @include('public.products.partials.product_card')
                                        @empty
                                            <h3>{{ trans('storefront::products.no_products_were_found') }}</h3>
                                        @endforelse
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div id="list-view" class="tab-pane {{ $viewMode === 'list' ? 'active' : '' }}">
                            @if ($viewMode === 'list')
                                @forelse ($products as $product)
                                    @include('public.products.partials.list_view_product_card')
                                @empty
                                    <h3>{{ trans('storefront::products.no_products_were_found') }}</h3>
                                @endforelse
                            @endif
                        </div>
                    </div>
                </div>

                <div class="pull-right">
                    {{ $products->links() }}
                </div>
            </div>
        </div>
    </section>
@endsection
