<section class="banners-wrapper">
    <div class="row">
        <div class="col-md-5">
            <?php echo $__env->make('public.home.sections.partials.single_banner', [
                'banner' => $bannerSectionThreeBanners[1],
                'class' => 'banner-sm',
            ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>

        <div class="col-md-7">
            <?php echo $__env->make('public.home.sections.partials.single_banner', [
                'banner' => $bannerSectionThreeBanners[2],
                'class' => 'banner-md',
            ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>
    </div>
</section>
<?php /**PATH C:\xampp\htdocs\fleetcart\Themes\Storefront\views/public/home/sections/banner_section_3.blade.php ENDPATH**/ ?>