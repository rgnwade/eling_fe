    
    <?php if(!empty($category)): ?>
    <section class="section-wrapper clearfix">
        <div class="section-header">
            <h3><?php echo e($category->name); ?></h3>
        </div>

        <div class="recent-products">
            <div class="row">
                <div class="grid-products separator">
                    <?php echo $__env->renderEach('public.products.partials.category_card', $category->child()->get(), 'category'); ?>
                </div>
            </div>
        </div>
    </section>
    <?php endif; ?>

<?php /**PATH C:\xampp\htdocs\fleetcart\Themes\Storefront\views/public/home/sections/category.blade.php ENDPATH**/ ?>