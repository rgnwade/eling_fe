<footer class="footer" style="background: #FCFCFC; ">
    <div class="container">
        <div class="footer-top p-tb-50 clearfix">

            <div class="row">
                <div class="col-md-12" style="margin-bottom: 50px; alignt:center;">
                    <div class="col-md-3 " style="text-align: center">
                        <img style="max-width:25%; margin-bottom:10px" src="{{url('')}}/other/1.png">
                        <h4> Pengiriman Terjamin </h4>
                        <br>
                        <p style="color: #707070">Eling melakukan pengiriman ke seluruh Indonesia</p>
                        </p>
                    </div>
                    <div class="col-md-3" style="text-align: center">
                        <img style="max-width:25%; margin-bottom:10px" src="{{url('')}}/other/2.png">
                        <br>
                        <h4>Produk Berkualitas</h4>
                        <br>
                        <p style="color: #707070"> Asli dan bergaransi resmi pabrikan </p>
                    </div>
                    <div class="col-md-3" style="text-align: center">
                        <img style="max-width:25%; margin-bottom:10px" src="{{url('')}}/other/3.png">
                        <h4>Pembayaran Digital </h4>
                        <br>
                        <p style="color: #707070">Mudah, cepat, dan aman dengan sertifikasi ISO 27001 untuk keamanan
                            data </p>
                    </div>
                    <div class="col-md-3" style="text-align: center">
                        <img style="max-width:25%; margin-bottom:10px" src="{{url('')}}/other/4.png">

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
                    <img style="max-width:100%;margin-bottom: 25px;" src="{{$shippingPayment}}">
                </div>
            </div>
            <div class="row p-tb-20 clearfix">


                <div class="col-md-12">
                    @if ($footerMenu->isNotEmpty())
                    <div class="col-sm-3">
                        <div class="row">
                            <div class="links">
                                <div class="mobile-collapse">
                                    <h4 style="color: black">{{ setting('storefront_footer_menu_title') }}</h4>
                                </div>

                                <ul class="list-inline">
                                    @foreach ($footerMenu as $menuItem)
                                    <li><a style="color: black" href="{{ $menuItem->url() }}">{{ $menuItem->name }}</a>
                                    </li>
                                    @endforeach
                                    @if(!auth()->user())
                                    <li><a style="color: black" href="{{ route('register_seller') }}">Jadi Seller di
                                            Eling</a>
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                    @endif

                    @if ($footerMenu2->isNotEmpty())
                    <div class="col-sm-3">
                        <div class="row">
                            <div class="links">
                                <div class="mobile-collapse">
                                    <h4 style="color: black">{{ setting('storefront_footer_menu_2_title') }}</h4>
                                </div>

                                <ul class="list-inline">
                                    @foreach ($footerMenu2 as $menuItem)
                                    <li><a style="color: black" href="{{ $menuItem->url() }}">{{ $menuItem->name }}</a>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                    @endif

                    <div class="col-sm-3">
                        <div class="row">
                            <div class="links">
                                <div class="mobile-collapse">
                                    <h4 style="color: black"> Keamanan</h4>
                                </div>

                                <ul class="list-inline">

                                    <img style="max-width:200px" src="{{$certified}}">
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
                                        {{-- @if (setting('store_phone'))
                                        <li>
                                            <i class="fa fa-phone-square" aria-hidden="true"></i>
                                            <span class="contact-info">{{ setting('store_phone') }}</span>
                                        </li>
                                        @endif

                                        @if (setting('store_email'))
                                        <li>
                                            <i class="fa fa-envelope-o" aria-hidden="true"></i>
                                            <span class="contact-info">{{ setting('store_email') }}</span>
                                        </li>
                                        @endif
                                        --}}

                                        @if (setting('storefront_footer_address'))
                                        <li>
                                            <i class="fa fa-location-arrow" aria-hidden="true"></i>
                                            {!! setting('storefront_footer_address') !!}
                                        </li>
                                        @endif
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
                {!! $copyrightText !!}
            </div>
        </div>
    </div>
</footer>
<!-- Popup -->
@if (request()->path() == '78')
<div class="custom-model-main">
    <div id="inner-popup" class="custom-model-inner">        
    <div class="close-btn">×</div>
        <div class="custom-model-wrap">
            <div class="pop-up-content-wrap">
             <div class="content-popup">
			<div class="modal-detail-btn">
                <a href="{{ route('autologin', ['key' => request()->path()])  }}" class="lgn-btn">PROMO</a>
                {{request()->path()}}
            </div>
			</div>
            </div>
        </div>  
    </div>  
    <div class="bg-overlay"></div>
</div> 
@endif
<!-- Popup -->
<script src="http://code.jquery.com/jquery-1.10.2.js"></script>
<script src="http://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<script>
	//Popup
	$(document).ready( function () {
  $(".custom-model-main").addClass('model-cstm-open');
}); 
$(".close-btn, .bg-overlay").click(function(){
  $(".custom-model-main").removeClass('model-cstm-open');
});
		//Popup
</script>