<?php $__env->startSection('title', trans('storefront::compare.compare')); ?>

<?php $__env->startSection('content'); ?>
    <section class="compare">
        <?php if($compare->hasAnyProduct()): ?>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <td><?php echo e(trans('storefront::compare.product_overview')); ?></td>

                            <?php $__currentLoopData = $compare->products(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <td class="product-overview">
                                    <?php if(! $product->base_image->exists): ?>
                                        <div class="image-placeholder">
                                            <i class="fa fa-picture-o" aria-hidden="true"></i>
                                        </div>
                                    <?php else: ?>
                                        <div class="image-holder">
                                            <img src="<?php echo e($product->base_image->thumb); ?>">
                                        </div>
                                    <?php endif; ?>

                                    <h5>
                                        <a href="<?php echo e(route('products.show', $product->slug)); ?>"><?php echo e($product->name); ?></a>
                                    </h5>

                                    <form method="POST" action="<?php echo e(route('compare.destroy', $product)); ?>">
                                        <?php echo e(csrf_field()); ?>

                                        <?php echo e(method_field('delete')); ?>


                                        <button type="submit" class="btn-close">&times;</button>
                                    </form>
                                </td>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tr>

                        <tr>
                            <td><?php echo e(trans('storefront::compare.price')); ?></td>

                            <?php $__currentLoopData = $compare->products(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <td>
                                    <span class="product-price"><?php echo e(product_price($product)); ?></span>
                                </td>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tr>

                        <?php $__currentLoopData = $compare->attributes(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $attribute): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($attribute->name); ?></td>

                                <?php $__currentLoopData = $compare->products(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php if($product->hasAttribute($attribute)): ?>
                                        <td><?php echo e($product->attributeValues($attribute)); ?></td>
                                    <?php else: ?>
                                        <td>&ndash;</td>
                                    <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        <tr>
                            <td><?php echo e(trans('storefront::compare.add_to_cart')); ?></td>

                            <?php $__currentLoopData = $compare->products(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <td>
                                    <?php if($product->options_count > 0): ?>
                                        <a href="<?php echo e(route('products.show', $product->slug)); ?>" class="btn btn-primary">
                                            <?php echo e(trans('storefront::compare.view_details')); ?>

                                        </a>
                                    <?php else: ?>
                                        <form method="POST" action="<?php echo e(route('cart.items.store')); ?>">
                                            <?php echo e(csrf_field()); ?>


                                            <input type="hidden" name="product_id" value="<?php echo e($product->id); ?>">
                                            <input type="hidden" name="qty" value="1">

                                            <button type="submit" class="btn btn-primary" <?php echo e($product->isOutOfStock() ? 'disabled' : ''); ?> data-loading>
                                                <?php echo e(trans('storefront::compare.add_to_cart')); ?>

                                            </button>
                                        </form>
                                    <?php endif; ?>
                                </td>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tr>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <h2 class="text-center"><?php echo e(trans('storefront::compare.no_product')); ?></h2>

            <a href="<?php echo e(url()->previous()); ?>" class="go-back-link">
                <i class="fa fa-reply" aria-hidden="true"></i>
                <?php echo e(trans('storefront::compare.go_back')); ?>

            </a>
        <?php endif; ?>
    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('public.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\fleetcart\Themes\Storefront\views/public/compare/index.blade.php ENDPATH**/ ?>