<!DOCTYPE html>
<html lang="<?php echo e(locale()); ?>">

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
        <?php if (! empty(trim($__env->yieldContent('title')))): ?>
        <?php echo $__env->yieldContent('title'); ?> - <?php echo e(setting('store_name')); ?>

        <?php else: ?>
        <?php echo e(setting('store_name')); ?>

        <?php endif; ?>
    </title>

    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <?php echo $__env->yieldPushContent('meta'); ?>

    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600|Rubik:400,500" rel="stylesheet">

    <?php if(is_rtl()): ?>
    <link rel="stylesheet" href="<?php echo e(v(Theme::url('public/css/app.rtl.css'))); ?>">
    <?php else: ?>
    <link rel="stylesheet" href="<?php echo e(v(Theme::url('public/css/app.css'))); ?>">
    <?php endif; ?>


    <link rel="shortcut icon" href="<?php echo e($favicon); ?>" type="image/x-icon">

    <?php echo $__env->yieldPushContent('styles'); ?>

    <?php echo setting('custom_header_assets'); ?>


    <script>
        window.FleetCart = {
                csrfToken: '<?php echo e(csrf_token()); ?>',
                stripePublishableKey: '<?php echo e(setting("stripe_publishable_key")); ?>',
                langs: {
                    'storefront::products.loading': '<?php echo e(trans("storefront::products.loading")); ?>',
                },
            };
    </script>

    <?php echo $__env->yieldPushContent('globals'); ?>

    <?php echo app('Tightenco\Ziggy\BladeRouteGenerator')->generate(); ?>
</head>

<body class="<?php echo e($theme); ?> <?php echo e(storefront_layout()); ?> <?php echo e(is_rtl() ? 'rtl' : 'ltr'); ?>">
<!-- Google Tag Manager (noscript) -->

<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-MTBG7CX" height="0" width="0"
        style="display:none;visibility:hidden"></iframe></noscript>

<!-- End Google Tag Manager (noscript) -->

    <!--[if lt IE 8]>
            <p>You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->

    <div class="main">
        <div class="wrapper">
            <?php echo $__env->make('public.partials.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php echo $__env->make('public.partials.top_nav', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php echo $__env->make('public.partials.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php echo $__env->make('public.partials.navbar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

            <div class="content-wrapper clearfix <?php echo e(request()->routeIs('cart.index') ? 'cart-page' : ''); ?>">
                <div class="container">
                    <?php echo $__env->make('public.partials.breadcrumb', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                    <?php if (! (request()->routeIs('home') || request()->routeIs('login') || request()->routeIs('register')
                    || request()->routeIs('reset') || request()->routeIs('reset.complete'))): ?>
                    <?php echo $__env->make('public.partials.notification', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    <?php endif; ?>

                    <?php echo $__env->yieldContent('content'); ?>
                </div>
            </div>

            <?php if(setting('storefront_brand_section_enabled') && $brands->isNotEmpty() && request()->routeIs('home')): ?>
            <section class="brands-wrapper">
                <div class="container">
                    <div class="row">
                        <div class="brands">
                            <?php $__currentLoopData = $brands; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $brand): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="col-md-3">
                                <div class="brand-image">
                                    <img src="<?php echo e($brand->path); ?>">
                                </div>
                            </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                </div>
            </section>
            <?php endif; ?>

            <?php echo $__env->make('public.partials.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

            <a class="scroll-top" href="#">
                <i class="fa fa-angle-up" aria-hidden="true"></i>
            </a>
        </div>


    </div>
    <a href="https://api.whatsapp.com/send?phone=<?php echo e(setting('whatsapp')); ?>" class="float-whatsapp" target="_blank">
        <i class="fa fa-whatsapp my-float-whatsapp"></i>
    </a>

    <?php echo $__env->make('public.partials.chat', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('public.partials.quick_view_modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <script src="<?php echo e(v(Theme::url('public/js/app.js'))); ?>"></script>
    <script src="https://cdn.polyfill.io/v2/polyfill.min.js"></script>
     
    <?php if(Route::currentRouteName() == 'home' && !auth()->check() && setting('storefront_banner_pop_up_enabled')): ?>
        <?php echo $__env->make('public.popup', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
   <?php endif; ?>
    <?php echo $__env->yieldPushContent('scripts'); ?>

    <?php echo setting('custom_footer_assets'); ?>

 
    <?php if(!auth()->check()): ?>
    <a href="<?php echo e(route('login')); ?>" class="float-chat-icon" target="_blank" data-toggle="tooltip" title=" <?php echo e(trans('storefront::storefront.chat_login_instruction')); ?>">
        <i class="fa fa-comments my-float-chat-icon"></i> <span style="font-size:19px; " >chat</span>
    </a>
    <?php endif; ?>
</body>

</html><?php /**PATH C:\xampp\htdocs\fleetcart\Themes\Storefront\views/public/layout.blade.php ENDPATH**/ ?>