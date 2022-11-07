<li class="<?php echo e($menu->hasSubMenus() ? 'dropdown' : ''); ?> <?php echo e($menu->isFluid() ? 'fluid-menu' : ''); ?>">
    <a href="<?php echo e($menu->url()); ?>" class="<?php echo e($menu->hasSubMenus() ? 'dropdown-toggle' : ''); ?>" target="<?php echo e($menu->target()); ?>">
        <?php echo e($menu->name()); ?>

    </a>

    <?php if($menu->isFluid()): ?>
        <?php echo $__env->make('public.partials.mega_menu.fluid', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php else: ?>
        <?php echo $__env->make('public.partials.mega_menu.dropdown', ['subMenus' => $menu->subMenus(), 'class' => 'multi-level'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php endif; ?>
</li>
<?php /**PATH C:\xampp\htdocs\fleetcart\Themes\Storefront\views/public/partials/mega_menu/menu.blade.php ENDPATH**/ ?>