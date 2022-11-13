@extends('public.layout')

@section('title', trans('storefront::contact.contact'))

@section('content')
<style>
    p {
        font-size: 16px;
        line-height: 26px;
        letter-spacing: 0.2px;
        color: #383838;
    }
</style>
<section class="contact-wrapper">

    <div class="row">
        <div class="col-md-6">
            <div class="contact-right clearfix black">
                <div>
                    <h3><b>Hubungi Kami </b></h3> <br>
                    <p>Untuk pertanyaan lebih lanjut mengenai eling.co.id, </p>
                    <p> silakan isi formulir di samping ini </p>
                    <p>atau bisa langsung hubungi kami melalui :</p>
                    <br>
                    <p> Call Center : <a href = "tel: 0216680223"> (021) 668-0223 </a> / <a href = "tel: 0216682033"> 668-2033 </a></p>
                    <p>WhatsApp: <a href="https://wa.me/+628119255476"> 0811 9255 476 </a></p>
                    <p>Email : <a href = "mailto: info@eling.co.id">info@eling.co.id</a> </p>
                    <p> Jam Operasional : 09.00 - 17.00 WIB (Senin - Jumat)</p>
                    <br>

                    <h5><b>Layanan Pengaduan Konsumen </b></h5>
                    <br>

                    <h6><b> DIREKTORAT JENDERAL PERLINDUNGAN KONSUMEN DAN TERTIB NIAGA
                            KEMENTERIAN PERDAGANGAN REPUBLIK INDONESIA <b></h6>
                    <br>

                    <p> Alamat : Gedung I Lantai 3, Jalan M.I. Ridwan Rais No. 5, <br> Jakarta Pusat 10110 </p>
                    <p> Whatsapp :  <a href="https://wa.me/+6285311111010">0853 1111 1010 </a></p>
                </div>

            </div>
        </div>
        <div class="col-md-6">
            <div class=" contact-left clearfix">
        
                <div class="col-md-12">
                    <form method="POST" action="{{ route('contact.store') }}" class="clearfix">
                        @csrf

                        <div class="form-group {{ $errors->has('email') ? 'has-error': '' }}">
                            <label for="email">{{ trans('contact::attributes.email') }}<span>*</span></label>
                            <input type="text" name="email" class="form-control" id="email" value="{{ old('email') }}">

                            {!! $errors->first('email', '<span class="error-message">:message</span>') !!}
                        </div>

                        <div class="form-group {{ $errors->has('subject') ? 'has-error': '' }}">
                            <label for="subject">{{ trans('contact::attributes.subject') }}<span>*</span></label>
                            <input type="text" name="subject" class="form-control" id="subject"
                                value="{{ old('subject') }}">

                            {!! $errors->first('subject', '<span class="error-message">:message</span>') !!}
                        </div>

                        <div class="form-group {{ $errors->has('message') ? 'has-error': '' }}">
                            <label for="message">{{ trans('contact::attributes.message') }}<span>*</span></label>
                            <textarea name="message" cols="30" rows="10" id="message">{{ old('message') }}</textarea>

                            {!! $errors->first('message', '<span class="error-message">:message</span>') !!}
                        </div>

                        <div class="form-group {{ $errors->has('captcha') ? 'has-error': '' }}">
                            @captcha
                            <input type="text" name="captcha" id="captcha" class="captcha-input">

                            {!! $errors->first('captcha', '<span class="error-message">:message</span>') !!}
                        </div>

                        <button type="submit" class="btn btn-primary btn-submit pull-left" data-loading>
                            {{ trans('storefront::contact.submit') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>


    </div>

</section>
@endsection