<!DOCTYPE html>
<html lang="{{ locale() }}">

<head>
    <style>
        div#popup-modal {
  display:none !important;
}

.modal-backdrop.in {
  opacity: 0;  
  display: none;
}

.modal-cstm-open {
  overflow: auto;
}

.modal-cstm-open .modal {
  overflow-y: hidden;
}

/*popup*/

.custom-model-main {
  text-align: center;
  overflow: hidden;
  position: fixed;
  top: 0;
  right: 0;
  bottom: 0;
  left: 0; /* z-index: 1050; */
  -webkit-overflow-scrolling: touch;
  outline: 0;
  opacity: 0;
  -webkit-transition: opacity 0.15s linear, z-index 0.15;
  -o-transition: opacity 0.15s linear, z-index 0.15;
  transition: opacity 0.15s linear, z-index 0.15;
  z-index: -1;
  overflow-x: hidden;
  overflow-y: auto;
}

.model-cstm-open {
  z-index: 99999;
  opacity: 1;
  overflow: hidden;
}
.custom-model-inner {
  -webkit-transform: translate(0, -200%);
  -ms-transform: translate(0, -200%);
  transform: translate(0, -200%);
  -webkit-transition: -webkit-transform 0.5s ease-out;
  -o-transition: -o-transform 0.3s ease-out;
  transition: -webkit-transform 0.3s ease-out;
  -o-transition: transform 0.3s ease-out;
  transition: transform 0.3s ease-out;
  transition: transform 0.3s ease-out, -webkit-transform 0.3s ease-out;
  display: inline-block;
  vertical-align: middle;
	 transition-delay: 1s;
}

.custom-model-wrap {
  display: block;
  width: 100%;
  position: relative;
/*   background-color: #fff; */
      padding: 50px;
/* 	 background-image: url(https://staging2.elfo.com/wp-content/uploads/2022/06/Public-Notice-1080x1080-1.png); */
  background-repeat: no-repeat;
    background-size: contain;
    background-position: center;
}
.model-cstm-open .custom-model-inner {
  -webkit-transform: translate(0, 0);
  -ms-transform: translate(0, 0);
  transform: translate(0, 0);
  position: relative;
  z-index: 999;
}


.model-cstm-open .bg-overlay {
  background: rgba(0, 0, 0, 0.6);
  z-index: 99;
}
.bg-overlay {
  background: rgba(0, 0, 0, 0);
  height: 100vh;
  width: 100%;
  position: fixed;
  left: 0;
  top: 0;
  right: 0;
  bottom: 0;
  z-index: 0;
  -webkit-transition: background 0.15s linear;
  -o-transition: background 0.15s linear;
  transition: background 0.15s linear;
}
.close-btn {
    position: absolute;
    right: 15px;
    top: 60px;
    cursor: pointer;
    z-index: 99;
    font-size: 35px;
    color: black;
}

@media screen and (min-width:800px){
	.custom-model-main:before {
	  content: "";
	  display: inline-block;
	  height: auto;
	  vertical-align: middle;
	  margin-right: -0px;
	  height: 100%;
	}
}
@media screen and (max-width:799px){
  .custom-model-inner{margin-top: 50%;}
}

p.popup-home {
	    font-family: "Glence-Heavy", Sans-serif;
	font-size:40px;
	font-weight:800;
	line-height:1.2;
	
}

.circle { 
   width: 170px;
    height: 170px;
   background: #f6fcfc; 
   -moz-border-radius: 70px; 
   -webkit-border-radius: 70px; 
   border-radius: 150px;
/*    border: solid 20px #00aae0; */
	position: absolute;
    z-index: -9;
    top: -45px;
    margin-left: auto;
margin-right: auto;
left: 0;
right: 0;
text-align: center;
}

img.logo-celebrate {
/*    top: -75px; */
    position: relative;
    max-width: 22%;
	padding-bottom: 15px;
	height: auto;
}

p.popup-home2 {
    font-size: 40px;
}

p.popup-home3 {
    font-size: 18px;
    font-weight: 600;
}

.content-popup {
    position: relative;
    top: -65px;
}

.sosmed-icon {
    padding-top: 15px;
}

img.icon-sos {
    padding: 0 7px;
	    width: auto;
}

@media(max-width:600px){
	.circle { 
  width: 130px;
    height: 130px;
    background: #f6fcfc;
    -moz-border-radius: 70px;
    -webkit-border-radius: 70px;
    border-radius: 150px;
/*     border: solid 20px #00aae0; */
    position: absolute;
    z-index: -9;
    top: -35px;
    margin-left: auto;
    margin-right: auto;
    left: 0;
    right: 0;
    text-align: center;
}
	img.logo-celebrate {
    top: 0;
    max-width: 22%;
	vertical-align: middle;
    border-style: none;
   height: auto;
    width: auto;
    -webkit-backface-visibility: hidden;
    -ms-transform: translateZ(0);
    -webkit-transform: translateZ(0);
    transform: translateZ(0);
}
	p.popup-home2 {
    font-size: 25px;
	margin-bottom: 0;
}

p.popup-home3 {
    font-size: 13px;
}
	p.popup-home {
    font-size: 25px;
	margin-bottom: 0;
}
	
	.custom-model-wrap {
    padding: 30px;
	}
	
	.sosmed-icon {
    padding-top: 0px;
}
	
	.close-btn {
    top: 40px;
	}
	
	.content-popup {
    top: -35px;
}
	lottie-player {
    position: absolute;
    height: auto;
    top: 25% !important;
    z-index: 111;
}
}

	lottie-player {
    position: absolute;
    height: auto;
    top: -200px;
    z-index: 111;
}

.circle::before {
      content: "";
    position: absolute;
    z-index: -1;
    top: -1px;
    left: -1px;
    right: -1px;
    bottom: 0;
    padding: 20px;
    border-radius: 150px;
  background: linear-gradient(to top, #029ACA , #10DDFF);
  -webkit-mask: 
     linear-gradient(#fff 0 0) content-box, 
     linear-gradient(#fff 0 0);
          mask: 
     linear-gradient(#fff 0 0) content-box, 
     linear-gradient(#fff 0 0);
  -webkit-mask-composite: xor;
  mask-composite: exclude;
}


.pop-up-content-wrap {
    max-width: 500px;
    width: 95%;
    margin: 50px auto;
    text-align: left;
}

img.pop-up-warn {
    width: 100%;
	height:auto;
}

.close-btn {
    position: absolute;
    right: 40px;
    top: 0px;
    cursor: pointer;
    z-index: 99;
    font-size: 25px;
    color: black;
}

.custom-model-wrap{
	padding:0;
}

@media(max-width:600px){
	.close-btn {
    position: absolute;
    right: 30px;
    top: 25px;
    cursor: pointer;
    z-index: 99;
    font-size: 25px;
    color: black;
}
}

.modal-detail-btn {
  background: white;
  padding: 20px;
}

/*popup*/
</style>

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