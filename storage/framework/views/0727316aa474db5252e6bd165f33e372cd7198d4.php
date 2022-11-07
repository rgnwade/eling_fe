<?php if($products->isNotEmpty()): ?>
    <section class="product-slider-wrapper clearfix">
        <div class="section-header">
            <h3><?php echo e($title); ?></h3>
        </div>

        <div class="row">
            <div class="product-slider slick-arrow separator clearfix">
                <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col-md-3">
                        <?php echo $__env->make('public.products.partials.product_card', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </section>
<?php endif; ?>
<?php /**PATH C:\xampp\htdocs\fleetcart\Themes\Storefront\views/public/home/sections/product_carousel.blade.php ENDPATH**/ ?>