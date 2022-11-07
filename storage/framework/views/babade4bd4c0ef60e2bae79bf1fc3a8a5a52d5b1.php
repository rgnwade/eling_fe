<?php $__env->startSection('breadcrumb'); ?>
    <?php if(request()->routeIs('account.dashboard.index')): ?>
        <li class="active"><?php echo e(trans('storefront::account.links.my_account')); ?></li>
    <?php else: ?>
        <li><a href="<?php echo e(route('account.dashboard.index')); ?>"><?php echo e(trans('storefront::account.links.my_account')); ?></a></li>
    <?php endif; ?>

    <?php echo $__env->yieldContent('account_breadcrumb'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="my-account clearfix">
            <div class="col-md-3">
                <div class="sidebar-menu">
                    <ul class="list-inline">
                        <li class="<?php echo e(request()->routeIs('account.dashboard.index') ? 'active' : ''); ?>">
                            <a href="<?php echo e(route('account.dashboard.index')); ?>">
                                <i class="fa fa-dashboard" aria-hidden="true"></i>
                                <?php echo e(trans('storefront::account.links.dashboard')); ?>

                            </a>
                        </li>

                        <li class="<?php echo e(request()->routeIs('account.orders.index') ? 'active' : ''); ?>">
                            <a href="<?php echo e(route('account.orders.index')); ?>">
                                <i class="fa fa-cart-arrow-down" aria-hidden="true"></i>
                                <?php echo e(trans('storefront::account.links.my_orders')); ?>

                            </a>
                        </li>

                        <li class="<?php echo e(request()->routeIs('account.wishlist.index') ? 'active' : ''); ?>">
                            <a href="<?php echo e(route('account.wishlist.index')); ?>">
                                <i class="fa fa-heart" aria-hidden="true"></i>
                                <?php echo e(trans('storefront::account.links.my_wishlist')); ?>

                            </a>
                        </li>

                        <li class="<?php echo e(request()->routeIs('account.reviews.index') ? 'active' : ''); ?>">
                            <a href="<?php echo e(route('account.reviews.index')); ?>">
                                <i class="fa fa-comment" aria-hidden="true"></i>
                                <?php echo e(trans('storefront::account.links.my_reviews')); ?>

                            </a>
                        </li>

                        <li class="<?php echo e(request()->routeIs('account.profile.edit') ? 'active' : ''); ?>">
                            <a href="<?php echo e(route('account.profile.edit')); ?>">
                                <i class="fa fa-user-circle-o" aria-hidden="true"></i>
                                <?php echo e(trans('storefront::account.links.my_profile')); ?>

                            </a>
                        </li>

                        <li>
                            <a href="<?php echo e(route('logout')); ?>">
                                <i class="fa fa-sign-out" aria-hidden="true"></i>
                                <?php echo e(trans('storefront::account.links.logout')); ?>

                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="col-md-9">
                <div class="clearfix"></div>

                <div class="content-right clearfix">
                    <?php echo $__env->yieldContent('content_right'); ?>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('public.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\fleetcart\Themes\Storefront\views/public/account/layout.blade.php ENDPATH**/ ?>