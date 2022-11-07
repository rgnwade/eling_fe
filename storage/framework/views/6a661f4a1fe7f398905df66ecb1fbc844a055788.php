<section class="banners-wrapper banners-group">
    <div class="row">
        <div class="col-md-8">
            <?php echo $__env->make('public.home.sections.partials.single_banner', [
                'banner' => $bannerSectionOneBanners[1],
                'class' => 'banner-md',
            ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

            <?php echo $__env->make('public.home.sections.partials.single_banner', [
                'banner' => $bannerSectionOneBanners[2],
                'class' => 'banner-md',
            ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>

        <div class="col-md-4">
            <?php echo $__env->make('public.home.sections.partials.single_banner', [
                'banner' => $bannerSectionOneBanners[3],
                'class' => 'banner-vr',
            ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>
    </div>
</section>
<?php /**PATH C:\xampp\htdocs\fleetcart\Themes\Storefront\views/public/home/sections/banner_section_1.blade.php ENDPATH**/ ?>