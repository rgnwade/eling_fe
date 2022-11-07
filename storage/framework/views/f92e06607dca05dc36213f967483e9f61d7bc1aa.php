<section class="section-wrapper clearfix">
    <div class="row">
        <?php if($threeColumnCarouselProducts['column_1']->isNotEmpty()): ?>
            <div class="col-md-4">
                <?php echo $__env->make('public.home.sections.partials.vertical_products', ['title' => setting("storefront_three_column_vertical_product_carousel_section_column_1_title"), 'products' => $threeColumnCarouselProducts['column_1']], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            </div>
        <?php endif; ?>

        <?php if($threeColumnCarouselProducts['column_2']->isNotEmpty()): ?>
            <div class="col-md-4">
                <?php echo $__env->make('public.home.sections.partials.vertical_products', ['title' => setting("storefront_three_column_vertical_product_carousel_section_column_2_title"), 'products' => $threeColumnCarouselProducts['column_2']], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            </div>
        <?php endif; ?>

        <?php if($threeColumnCarouselProducts['column_3']->isNotEmpty()): ?>
            <div class="col-md-4">
                <?php echo $__env->make('public.home.sections.partials.vertical_products', ['title' => setting("storefront_three_column_vertical_product_carousel_section_column_3_title"), 'products' => $threeColumnCarouselProducts['column_3']], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            </div>
        <?php endif; ?>
    </div>
</section>
<?php /**PATH C:\xampp\htdocs\fleetcart\Themes\Storefront\views/public/home/sections/three_column_vertical_product_carousel.blade.php ENDPATH**/ ?>