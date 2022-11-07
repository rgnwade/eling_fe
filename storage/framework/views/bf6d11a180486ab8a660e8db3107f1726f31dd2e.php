<?php $__env->startSection('title', trans('storefront::account.links.dashboard')); ?>

<?php $__env->startSection('content_right'); ?>
    <div class="my-dashboard">
        <div class="recent-orders index-table">
            <h4 class="section-header">
                <?php echo e(trans('storefront::account.dashboard.recent_orders')); ?>


                <?php if($recentOrders->isNotEmpty()): ?>
                    <a href="<?php echo e(route('account.orders.index')); ?>" class="pull-right">
                        <?php echo e(trans('storefront::account.dashboard.view_all')); ?>

                    </a>
                <?php endif; ?>
            </h4>

            <?php if($recentOrders->isEmpty()): ?>
                <span><?php echo e(trans('storefront::account.orders.no_orders')); ?></span>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th><?php echo e(trans('storefront::account.orders.order_id')); ?></th>
                                <th><?php echo e(trans('storefront::account.orders.date')); ?></th>
                                <th><?php echo e(trans('storefront::account.orders.status')); ?></th>
                                <th><?php echo e(trans('storefront::account.orders.total')); ?></th>
                                <th></th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php $__currentLoopData = $recentOrders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td>#<?php echo e($order->id); ?></td>
                                    <td><?php echo e($order->created_at->toFormattedDateString()); ?></td>
                                    <td><?php echo e($order->status()); ?></td>
                                    <td><?php echo e($order->total->convert($order->currency, $order->currency_rate)->format($order->currency)); ?></td>
                                    <td>
                                        <a href="<?php echo e(route('account.orders.show', $order)); ?>" class="btn-view" data-toggle="tooltip" title="<?php echo e(trans('storefront::account.orders.view_order')); ?>" rel="tooltip">
                                            <i class="fa fa-eye" aria-hidden="true"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>

        <div class="clearfix"></div>

        <div class="account-information clearfix">
            <h4><?php echo e(trans('storefront::account.dashboard.account_information')); ?></h4>

            <div class="col-md-6">
                <div class="row">
                    <div class="contact-information">
                        <span><?php echo e($my->full_name); ?></span>
                        <span><?php echo e($my->email); ?></span>

                        <a href="<?php echo e(route('account.profile.edit')); ?>">
                            <?php echo e(trans('storefront::account.dashboard.edit')); ?>

                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('public.account.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\fleetcart\Themes\Storefront\views/public/account/dashboard/index.blade.php ENDPATH**/ ?>