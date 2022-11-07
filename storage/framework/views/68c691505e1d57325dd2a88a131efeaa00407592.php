<?php if($recentProducts->isNotEmpty()): ?>
    <section class="section-wrapper clearfix">
        <div class="section-header">
            <h3><?php echo e(setting('storefront_recent_products_section_title')); ?></h3>
        </div>

        <div class="recent-products">
            <div class="row">
                <div class="grid-products separator">
                    <?php echo $__env->renderEach('public.products.partials.product_card', $recentProducts, 'product'); ?>
                </div>
            </div>
        </div>
    </section>
<?php endif; ?>
<?php /**PATH C:\xampp\htdocs\fleetcart\Themes\Storefront\views/public/home/sections/recent_products.blade.php ENDPATH**/ ?>