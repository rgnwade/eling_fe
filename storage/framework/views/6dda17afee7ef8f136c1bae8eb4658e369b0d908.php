<a href="<?php echo e(url('products')); ?>?category=<?php echo e($category->slug); ?>" class="product-card">
    <div class="product-card-inner">
        <div class="product-image clearfix">

            <?php if(! $category->logo->exists): ?>
            <div class="image-placeholder">
                <i class="fa fa-picture-o" aria-hidden="true"></i>
            </div>
            <?php else: ?>
            <div class="image-holder">
                <img src="<?php echo e($category->logo->thumb); ?>">
            </div>
            <?php endif; ?>

        </div>

        <div class="product-content clearfix">
            <span class="product-name"> <?php echo e($category->name); ?></span>
        </div>
    </div>
</a><?php /**PATH C:\xampp\htdocs\fleetcart\Themes\Storefront\views/public/products/partials/category_card.blade.php ENDPATH**/ ?>