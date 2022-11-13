<?php if($recentProducts->isNotEmpty()): ?>

<style>
    .link {
        color: #ea1b25;
        font-weight: 600;
        display: inline-block;

        -webkit-transition: 200ms ease-in-out;
        transition: 200ms ease-in-out;


    }

    a:hover,
    a:focus {
        color: #ea1b25;
    }
</style>
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
        
        <div class="banner pull-right">
            <div class="display-table">
                <div class="display-table-cell">
                    <div class="banner-content">

                        <span class="pull-left">
                            <a href="<?php echo e(url('recent-products')); ?>" class="link"> Lihat semua</a>

                            <i class="fa fa-long-arrow-right" aria-hidden="true"></i>

                        </span> &nbsp;&nbsp;
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php endif; ?><?php /**PATH C:\xampp\htdocs\fleetcart\Themes\Storefront\views/public/home/sections/recent_products.blade.php ENDPATH**/ ?>