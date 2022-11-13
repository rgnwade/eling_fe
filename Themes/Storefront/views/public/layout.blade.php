<!DOCTYPE html>
<html lang="{{ locale() }}">

<head>

<!-- Google Tag Manager -->

<script>
    (function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':

    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
    
    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
    
    'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    
    })(window,document,'script','dataLayer','GTM-MTBG7CX');
</script>

<!-- End Google Tag Manager -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>
        @hasSection('title')
        @yield('title') - {{ setting('store_name') }}
        @else
        {{ setting('store_name') }}
        @endif
    </title>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    @stack('meta')

    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600|Rubik:400,500" rel="stylesheet">

    @if (is_rtl())
    <link rel="stylesheet" href="{{ v(Theme::url('public/css/app.rtl.css')) }}">
    @else
    <link rel="stylesheet" href="{{ v(Theme::url('public/css/app.css')) }}">
    @endif


    <link rel="shortcut icon" href="{{ $favicon }}" type="image/x-icon">

    @stack('styles')

    {!! setting('custom_header_assets') !!}

    <script>
        window.FleetCart = {
                csrfToken: '{{ csrf_token() }}',
                stripePublishableKey: '{{ setting("stripe_publishable_key") }}',
                langs: {
                    'storefront::products.loading': '{{ trans("storefront::products.loading") }}',
                },
            };
    </script>

    @stack('globals')

    @routes
</head>

<body class="{{ $theme }} {{ storefront_layout() }} {{ is_rtl() ? 'rtl' : 'ltr' }}">
<!-- Google Tag Manager (noscript) -->

<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-MTBG7CX" height="0" width="0"
        style="display:none;visibility:hidden"></iframe></noscript>

<!-- End Google Tag Manager (noscript) -->

    <!--[if lt IE 8]>
            <p>You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->

    <div class="main">
        <div class="wrapper">
            @include('public.partials.sidebar')
            @include('public.partials.top_nav')
            @include('public.partials.header')
            @include('public.partials.navbar')

            <div class="content-wrapper clearfix {{ request()->routeIs('cart.index') ? 'cart-page' : '' }}">
                <div class="container">
                    @include('public.partials.breadcrumb')

                    @unless (request()->routeIs('home') || request()->routeIs('login') || request()->routeIs('register')
                    || request()->routeIs('reset') || request()->routeIs('reset.complete'))
                    @include('public.partials.notification')
                    @endunless

                    @yield('content')
                </div>
            </div>

            @if (setting('storefront_brand_section_enabled') && $brands->isNotEmpty() && request()->routeIs('home'))
            <section class="brands-wrapper">
                <div class="container">
                    <div class="row">
                        <div class="brands">
                            @foreach ($brands as $brand)
                            <div class="col-md-3">
                                <div class="brand-image">
                                    <img src="{{ $brand->path }}">
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </section>
            @endif

            @include('public.partials.footer')

            <a class="scroll-top" href="#">
                <i class="fa fa-angle-up" aria-hidden="true"></i>
            </a>
        </div>


    </div>
    <a href="https://api.whatsapp.com/send?phone={{ setting('whatsapp') }}" class="float-whatsapp" target="_blank">
        <i class="fa fa-whatsapp my-float-whatsapp"></i>
    </a>

    @include('public.partials.chat')
    @include('public.partials.quick_view_modal')
    <script src="{{ v(Theme::url('public/js/app.js')) }}"></script>
    <script src="https://cdn.polyfill.io/v2/polyfill.min.js"></script>
     
    @if(Route::currentRouteName() == 'home' && !auth()->check() && setting('storefront_banner_pop_up_enabled'))
        @include('public.popup')
   @endif
    @stack('scripts')

    {!! setting('custom_footer_assets') !!}
 
    @if(!auth()->check())
    <a href="{{ route('login') }}" class="float-chat-icon" target="_blank" data-toggle="tooltip" title=" {{ trans('storefront::storefront.chat_login_instruction') }}">
        <i class="fa fa-comments my-float-chat-icon"></i> <span style="font-size:19px; " >chat</span>
    </a>
    @endif
</body>

</html>