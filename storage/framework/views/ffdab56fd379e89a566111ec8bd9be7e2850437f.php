<ul>
    <?php $__currentLoopData = $subMenus; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subMenu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <li class="submenu">
            <a href="<?php echo e($subMenu->url()); ?>"><?php echo e($subMenu->name()); ?></a>

            <?php if($subMenu->hasItems()): ?>
                <?php echo $__env->make('public.partials.nested_sidebar', ['subMenus' => $subMenu->items()], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php endif; ?>
        </li>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</ul>
<?php /**PATH C:\xampp\htdocs\fleetcart\Themes\Storefront\views/public/partials/nested_sidebar.blade.php ENDPATH**/ ?>