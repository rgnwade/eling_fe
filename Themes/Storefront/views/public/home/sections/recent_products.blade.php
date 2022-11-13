@if ($recentProducts->isNotEmpty())

<style>
    .link {
        color: #ea1b25;
        font-weight: 600;
        display: inline-block;

        -webkit-transition: 200ms ease-in-out;
        transition: 200ms ease-in-out;


    }

    a:hover,
    a:focus {
        color: #ea1b25;
    }
</style>
<section class="section-wrapper clearfix">
    <div class="section-header">
        <h3>{{ setting('storefront_recent_products_section_title') }}</h3>
    </div>

    <div class="recent-products">
        <div class="row">
            <div class="grid-products separator">
                @each('public.products.partials.product_card', $recentProducts, 'product')
            </div>
        </div>
        {{-- <a href="{{url('recent-products')}}" class="link pull-right">
        <span>
            Lihat semua
            <i class="fa fa-long-arrow-right" aria-hidden="true"></i>
        </span>
        </a> --}}
        <div class="banner pull-right">
            <div class="display-table">
                <div class="display-table-cell">
                    <div class="banner-content">

                        <span class="pull-left">
                            <a href="{{url('recent-products')}}" class="link"> Lihat semua</a>

                            <i class="fa fa-long-arrow-right" aria-hidden="true"></i>

                        </span> &nbsp;&nbsp;
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endif