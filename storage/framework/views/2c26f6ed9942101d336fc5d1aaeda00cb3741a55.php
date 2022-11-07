<a href="<?php echo e(route('products.show', $product->slug)); ?>" class="single-product">
    <?php if(! $product->base_image->exists): ?>
        <div class="image-placeholder">
            <i class="fa fa-picture-o" aria-hidden="true"></i>
        </div>
    <?php else: ?>
        <div class="image-holder">
            <img src="<?php echo e($product->base_image->path); ?>">
        </div>
    <?php endif; ?>

    <div class="single-product-details">
        <span class="product-name"><?php echo e($product->name); ?></span>

        <span class="product-price">
            <?php echo e(product_price($product)); ?>

        </span>
    </div>
</a>
<?php /**PATH C:\xampp\htdocs\fleetcart\Themes\Storefront\views/public/products/partials/single_product.blade.php ENDPATH**/ ?>