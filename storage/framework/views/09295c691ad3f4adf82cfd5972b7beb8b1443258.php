<footer class="footer" style="background: #FCFCFC; ">
    <div class="container">
        <div class="footer-top p-tb-50 clearfix">

            <div class="row">
                <div class="col-md-12" style="margin-bottom: 50px; alignt:center;">
                    <div class="col-md-3 " style="text-align: center">
                        <img style="max-width:25%; margin-bottom:10px" src="<?php echo e(url('')); ?>/other/1.png">
                        <h4> Pengiriman Terjamin </h4>
                        <br>
                        <p style="color: #707070">Eling melakukan pengiriman ke seluruh Indonesia</p>
                        </p>
                    </div>
                    <div class="col-md-3" style="text-align: center">
                        <img style="max-width:25%; margin-bottom:10px" src="<?php echo e(url('')); ?>/other/2.png">
                        <br>
                        <h4>Produk Berkualitas</h4>
                        <br>
                        <p style="color: #707070"> Asli dan bergaransi resmi pabrikan </p>
                    </div>
                    <div class="col-md-3" style="text-align: center">
                        <img style="max-width:25%; margin-bottom:10px" src="<?php echo e(url('')); ?>/other/3.png">
                        <h4>Pembayaran Digital </h4>
                        <br>
                        <p style="color: #707070">Mudah, cepat, dan aman dengan sertifikasi ISO 27001 untuk keamanan
                            data </p>
                    </div>
                    <div class="col-md-3" style="text-align: center">
                        <img style="max-width:25%; margin-bottom:10px" src="<?php echo e(url('')); ?>/other/4.png">

                        <h4>Pelayanan Mantap </h4>
                        <br>
                        <p style="color: #707070">Layanan instalasi dan pemeliharaan oleh teknisi berpengalaman</p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12" style="border-bottom: 1px solid #d9d9d9; margin-bottom: 25px;">
                    <div class="mobile-collapse">
                        <h4 style="color: black;     text-align: center; margin-bottom: 10px;">Pembayaran dan Pengiriman
                        </h4>
                    </div>
                    <img style="max-width:100%;margin-bottom: 25px;" src="<?php echo e($shippingPayment); ?>">
                </div>
            </div>
            <div class="row p-tb-20 clearfix">


                <div class="col-md-12">
                    <?php if($footerMenu->isNotEmpty()): ?>
                    <div class="col-sm-3">
                        <div class="row">
                            <div class="links">
                                <div class="mobile-collapse">
                                    <h4 style="color: black"><?php echo e(setting('storefront_footer_menu_title')); ?></h4>
                                </div>

                                <ul class="list-inline">
                                    <?php $__currentLoopData = $footerMenu; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $menuItem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li><a style="color: black" href="<?php echo e($menuItem->url()); ?>"><?php echo e($menuItem->name); ?></a>
                                    </li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php if(!auth()->user()): ?>
                                    <li><a style="color: black" href="<?php echo e(route('register_seller')); ?>">Jadi Seller di
                                            Eling</a>
                                    <?php endif; ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>

                    <?php if($footerMenu2->isNotEmpty()): ?>
                    <div class="col-sm-3">
                        <div class="row">
                            <div class="links">
                                <div class="mobile-collapse">
                                    <h4 style="color: black"><?php echo e(setting('storefront_footer_menu_2_title')); ?></h4>
                                </div>

                                <ul class="list-inline">
                                    <?php $__currentLoopData = $footerMenu2; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $menuItem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li><a style="color: black" href="<?php echo e($menuItem->url()); ?>"><?php echo e($menuItem->name); ?></a>
                                    </li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>

                    <div class="col-sm-3">
                        <div class="row">
                            <div class="links">
                                <div class="mobile-collapse">
                                    <h4 style="color: black"> Keamanan</h4>
                                </div>

                                <ul class="list-inline">

                                    <img style="max-width:200px" src="<?php echo e($certified); ?>">
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-3">
                        <div class="row">
                            <div class="links">
                                <div class="mobile-collapse">
                                    <h4 style="color: black"> Layanan Pelanggan</h4>
                                </div>

                                <ul class="list-inline">
                                    <ul class="list-inline" style="padding-left: 5px">

                                        <li>
                                            <i class="fa fa-whatsapp" aria-hidden="true"></i>
                                            <a href="https://wa.me/+628119255476" style="color: black"> 0811 9255 476
                                            </a>
                                        <li>
                                            <i class="fa fa-phone" aria-hidden="true"></i>
                                            <a href="tel: 0216680223" style="color: black">
                                                (021) 668-0223 </a> / <a style="color: black" href="tel: 0216682033">
                                                668-2033 </a>
                                        </li>
                                        <li>
                                            <i class="fa fa-envelope" aria-hidden="true"></i>
                                            <a style="color: black" href="mailto: info@eling.co.id">info@eling.co.id</a>
                                        </li>
                                        

                                        <?php if(setting('storefront_footer_address')): ?>
                                        <li>
                                            <i class="fa fa-location-arrow" aria-hidden="true"></i>
                                            <?php echo setting('storefront_footer_address'); ?>

                                        </li>
                                        <?php endif; ?>
                                    </ul>
                                </ul>
                            </div>

                            <div class="links">
                                <div class="mobile-collapse">
                                    <h4 style="color: black"> Layanan Pengaduan Konsumen</h4>
                                </div>

                                <ul class="list-inline">
                                    <ul class="list-inline" style="padding-left: 5px">


                                        <li>
                                            Direktorat Jenderal Perlindungan Konsumen dan Tertib Niaga Kementerian
                                            Perdagangan Republik Indonesia
                                        </li>
                                        <li>
                                            <i class="fa fa-whatsapp" aria-hidden="true"></i>
                                            <a href="https://wa.me/+6285311111010" style="color: black">0853 1111 1010
                                            </a>
                                        </li>

                                    </ul>
                                </ul>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="footer-bottom p-tb-20 clearfix" style="background: #FCFCFC; ">
        <div class="container">
            <div class="copyright text-center" style="color: black">
                <?php echo $copyrightText; ?>

            </div>
        </div>
    </div>
</footer><?php /**PATH C:\xampp\htdocs\fleetcart\Themes\Storefront\views/public/partials/footer.blade.php ENDPATH**/ ?>