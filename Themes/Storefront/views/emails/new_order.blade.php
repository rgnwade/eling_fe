<!DOCTYPE html PUBLIC>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="x-apple-disable-message-reformatting" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="coloml">
    <html lang=" id">

    <head>
        <title>invoice #{{$order->id}}</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="supported-color-schemes" content="light dark" />
        <title></title>
        <style type="text/css" rel="stylesheet" media="all">
            /* Base ------------------------------ */

            @import url("https://fonts.googleapis.com/css?family=Nunito+Sans:400,700&display=swap");

            body {
                width: 100% !important;
                height: 100%;
                margin: 0;
                -webkit-text-size-adjust: none;
            }

            a {
                color: #EA1B25;
            }

            a img {
                border: none;
            }

            td {
                word-break: break-word;
            }

            .preheader {
                display: none !important;
                visibility: hidden;
                mso-hide: all;
                font-size: 1px;
                line-height: 1px;
                max-height: 0;
                max-width: 0;
                opacity: 0;
                overflow: hidden;
            }

            /* Type ------------------------------ */

            body,
            td,
            th {
                font-family: "Nunito Sans", Helvetica, Arial, sans-serif;
            }

            h1 {
                margin-top: 0;
                font-size: 22px;
                font-weight: bold;
            }

            h2 {
                margin-top: 0;
                color: #e84953;
                font-size: 16px;
                font-weight: bold;
            }

            h3 {
                margin-top: 0;
                color: #333333;
                font-size: 14px;
                font-weight: bold;
            }

            td,
            th {
                font-size: 12px;
            }

            p,
            ul,
            ol,
            blockquote {
                margin: .4em 0 1.1875em;
                font-size: 12px;
                line-height: 1.625;
            }

            p.sub {
                font-size: 12px;
            }

            /* Utilities ------------------------------ */

            .align-right {
                text-align: right;
            }

            .align-left {
                text-align: left;
            }

            .align-center {
                text-align: center;
            }

            /* Buttons ------------------------------ */

            .button {
                background-color: #3869D4;
                border-top: 10px solid #3869D4;
                border-right: 18px solid #3869D4;
                border-bottom: 10px solid #3869D4;
                border-left: 18px solid #3869D4;
                display: inline-block;
                color: #FFF;
                text-decoration: none;
                border-radius: 3px;
                box-shadow: 0 2px 3px rgba(0, 0, 0, 0.16);
                -webkit-text-size-adjust: none;
                box-sizing: border-box;
            }

            .button--green {
                background-color: #22BC66;
                border-top: 10px solid #22BC66;
                border-right: 18px solid #22BC66;
                border-bottom: 10px solid #22BC66;
                border-left: 18px solid #22BC66;
            }

            .button--red {
                background-color: #EA1B25;
                border-top: 10px solid #EA1B25;
                border-right: 18px solid #EA1B25;
                border-bottom: 10px solid #EA1B25;
                border-left: 18px solid #EA1B25;
            }

            @media only screen and (max-width: 500px) {
                .button {
                    width: 100% !important;
                    text-align: center !important;
                }
            }

            /* Attribute list ------------------------------ */

            .attributes {
                margin: 0 0 21px;
            }

            .attributes_content {
                background-color: #F4F4F7;
                padding: 16px;
            }

            .attributes_item {
                padding: 0;
            }

            /* Related Items ------------------------------ */

            .related {
                width: 100%;
                margin: 0;
                padding: 25px 0 0 0;
                -premailer-width: 100%;
                -premailer-cellpadding: 0;
                -premailer-cellspacing: 0;
            }

            .related_item {
                padding: 10px 0;
                color: #CBCCCF;
                font-size: 15px;
                line-height: 18px;
            }

            .related_item-title {
                display: block;
                margin: .5em 0 0;
            }

            .related_item-thumb {
                display: block;
                padding-bottom: 10px;
            }

            .related_heading {
                border-top: 1px solid #CBCCCF;
                text-align: center;
                padding: 25px 0 10px;
            }

            /* Discount Code ------------------------------ */

            .discount {
                width: 100%;
                margin: 0;
                padding: 24px;
                -premailer-width: 100%;
                -premailer-cellpadding: 0;
                -premailer-cellspacing: 0;
                background-color: #F4F4F7;
                border: 2px dashed #CBCCCF;
            }

            .discount_heading {
                text-align: center;
            }

            .discount_body {
                text-align: center;
                font-size: 15px;
            }

            /* Social Icons ------------------------------ */

            .social {
                width: auto;
            }

            .social td {
                padding: 0;
                width: auto;
            }

            .social_icon {
                height: 20px;
                margin: 0 8px 10px 8px;
                padding: 0;
            }

            /* Data table ------------------------------ */

            .purchase {
                width: 100%;
                margin: 0;
                padding: 35px 0;
                -premailer-width: 100%;
                -premailer-cellpadding: 0;
                -premailer-cellspacing: 0;
            }

            .address {
                width: 100%;
                margin: 0;
                padding: 16px 0;
                -premailer-width: 100%;
                -premailer-cellpadding: 0;
                -premailer-cellspacing: 0;
                background-color: #F4F4F7;
            }

            .purchase_content {
                width: 100%;
                margin: 0;
                padding: 25px 0 0 0;
                -premailer-width: 100%;
                -premailer-cellpadding: 0;
                -premailer-cellspacing: 0;
            }

            .purchase_item {
                padding: 10px 0;
                color: #51545E;
                font-size: 15px;
                line-height: 18px;
            }

            .purchase_heading {
                padding-bottom: 8px;
                border-bottom: 1px solid #EAEAEC;
            }

            .purchase_heading p {
                margin: 0;
                color: #85878E;
                font-size: 12px;
            }

            .purchase_footer {
                padding-top: 15px;
                border-top: 1px solid #dad4d4;
            }

            .purchase_total {
                margin: 0;
                text-align: right;
                font-weight: bold;
                color: #333333;
            }

            .purchase_total--label {
                padding: 0 15px 0 0;
            }

            body {
                background-color: #F2F4F6;
                color: #51545E;
            }

            p {
                color: #51545E;
            }

            .email-wrapper {
                width: 100%;
                margin: 0;
                padding: 0;
                -premailer-width: 100%;
                -premailer-cellpadding: 0;
                -premailer-cellspacing: 0;
                background-color: #F2F4F6;
            }

            .email-content {
                width: 100%;
                margin: 0;
                padding: 0;
                -premailer-width: 100%;
                -premailer-cellpadding: 0;
                -premailer-cellspacing: 0;
            }

            /* Masthead ----------------------- */

            .email-masthead {
                padding: 15px 0;
                text-align: center;
            }

            .email-masthead_logo {
                width: 94px;
            }

            .email-masthead_name {
                font-size: 16px;
                font-weight: bold;
                color: #A8AAAF;
                text-decoration: none;
                text-shadow: 0 1px 0 white;
            }

            /* Body ------------------------------ */

            .email-body {
                width: 100%;
                margin: 0;
                padding: 0;
                -premailer-width: 100%;
                -premailer-cellpadding: 0;
                -premailer-cellspacing: 0;
            }

            .email-body_inner {
                width: 570px;
                margin: 0 auto;
                padding: 0;
                -premailer-width: 570px;
                -premailer-cellpadding: 0;
                -premailer-cellspacing: 0;
                background-color: #FFFFFF;
            }

            .email-footer {
                width: 570px;
                margin: 0 auto;
                padding: 0;
                -premailer-width: 570px;
                -premailer-cellpadding: 0;
                -premailer-cellspacing: 0;
                text-align: center;
            }

            .email-footer p {
                color: #A8AAAF;
            }

            .body-action {
                width: 100%;
                margin: 30px auto;
                padding: 0;
                -premailer-width: 100%;
                -premailer-cellpadding: 0;
                -premailer-cellspacing: 0;
                text-align: center;
            }

            .body-sub {
                margin-top: 25px;
                padding-top: 25px;
                border-top: 1px solid #EAEAEC;
            }

            .content-cell {
                padding: 30px;
            }

            /*Media Queries ------------------------------ */

            @media only screen and (max-width: 600px) {

                .email-body_inner,
                .email-footer {
                    width: 100% !important;
                }
            }

            @media (prefers-color-scheme: dark) {

                body,
                .email-body,
                .email-body_inner,
                .email-content,
                .email-wrapper,
                .email-masthead,
                .email-footer {
                    background-color: #333333 !important;
                    color: #FFF !important;
                }

                p,
                ul,
                ol,
                blockquote,
                h1,
                h2,
                h3 {
                    color: #FFF !important;
                }

                .attributes_content,
                .discount {
                    background-color: #222 !important;
                }

                .email-masthead_name {
                    text-shadow: none !important;
                }
            }

            :root {
                color-scheme: light dark;
                supported-color-schemes: light dark;
            }
        </style>
        <!--[if mso]>
    <style type="text/css">
      .f-fallback  {
        font-family: Arial, sans-serif;
      }
    </style>
  <![endif]-->
    </head>

<body>
    <span class="preheader">This is an invoice for your purchase on {! purchase_date }}. Please submit payment by {!
        due_date }}</span>
    <table class="email-wrapper" width="100%" cellpadding="0" cellspacing="0" role="presentation">
        <tr>
            <td align="center">
                <table class="email-content" width="100%" cellpadding="0" cellspacing="0" role="presentation">
                    <tr>
                        <td class="email-masthead">
                            <a href="https:www.eling.co.id" class="f-fallback email-masthead_name">
                                #saatnyaeling
                            </a>
                        </td>
                    </tr>
                    <!-- Email Body -->
                    <tr>
                        <td class="email-body" width="570" cellpadding="0" cellspacing="0">
                            <table class="email-body_inner" align="center" width="570" cellpadding="0" cellspacing="0"
                                role="presentation">
                                <!-- Body content -->
                                <tr>
                                    <td class="content-cell">
                                        <div class="f-fallback">
                                            <a href="https://www.eling.co.id">
                                                <img src="{{ $logo }}" width="140px">
                                            </a>

                                            <h1 align="center">New Customer Order</h1>
                                            <p>You've received the following order on date
                                                {{$order->created_at->format('d/m/Y H:i') }} WIB</p>

                                            <table class="attributes" width="100%" cellpadding="0" cellspacing="0"
                                                role="presentation">
                                                <tr>
                                                    <td class="attributes_content">
                                                        <table width="100%" cellpadding="0" cellspacing="5"
                                                            role="presentation">
                                                            <tr>
                                                                <td class="attributes_item" colspan="2">
                                                                    <span class="f-fallback">
                                                                        <strong>Detail Pemesanan</strong>
                                                                    </span>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td class="attributes_item">
                                                                    <span class="f-fallback">
                                                                        {{ trans('storefront::invoice.order_id') }}:
                                                                    </span>
                                                                </td>
                                                                <td class="attributes_item">
                                                                    <span class="f-fallback">
                                                                        #{{$order->id}}
                                                                    </span>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td class="attributes_item">
                                                                    <span class="f-fallback">
                                                                        {{ trans('order::invoice.date') }}
                                                                    </span>
                                                                </td>
                                                                <td class="attributes_item">
                                                                    <span class="f-fallback">
                                                                        {{ $order->created_at->format('d/m/Y') }}
                                                                    </span>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td class="attributes_item">
                                                                    <span class="f-fallback">
                                                                        Email:
                                                                    </span>
                                                                </td>
                                                                <td class="attributes_item">
                                                                    <span class="f-fallback">
                                                                        {{ $order->customer_email}}
                                                                    </span>
                                                                </td>
                                                            <tr>
                                                                <td class="attributes_item">
                                                                    <span class="f-fallback">
                                                                        Perusahaan:
                                                                    </span>
                                                                </td>
                                                                <td class="attributes_item">
                                                                    <span class="f-fallback">
                                                                        {{$order->customer->company->name}}
                                                                    </span>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td class="attributes_item">
                                                                    <span class="f-fallback">
                                                                        {{ trans('storefront::account.payments.term') }}:
                                                                    </span>
                                                                </td>
                                                                <td class="attributes_item">
                                                                    <span class="f-fallback">
                                                                        {{$order->payment_term() }}
                                                                    </span>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td class="attributes_item">
                                                                    <span class="f-fallback">
                                                                        Status:
                                                                    </span>
                                                                </td>
                                                                <td class="attributes_item">
                                                                    <span class="f-fallback">
                                                                        {{$order->status() }}
                                                                    </span>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                </tr>
                                            </table>

                                     


                                            <table class="purchase" width="100%" cellpadding="0" cellspacing="0">

                                                <tr>
                                                    <td width="40%">
                                                        <h3>Produk</h3>
                                                    </td>
                                                    <td width="20%">
                                                        <h3>Harga</h3>
                                                    </td>

                                                    <td width="10%">
                                                        <h3>Qty</h3>
                                                    </td>
                                                    <td width="30%">
                                                        <h3 class="align-right">Jumlah</h3>
                                                    </td>
                                                </tr>
                                                @foreach ($order->products as $product)
                                                <tr>
                                                    <td>
                                                        <a
                                                            href="{{ route('products.show', ['slug' => $product->slug]) }}">
                                                            {{ $product->name }}
                                                        </a>
                                                        <div class="option">
                                                            <span> {{  trans('product::attributes.weight') }}:
                                                                <span>{{ $product->weight }}
                                                                    Kg</span></span> <br>
                                                            <span> {{ trans('storefront::cart.weight_total') }}
                                                                <span>{{ $product->weight * $product->qty }}
                                                                    Kg</span></span>

                                                            @if ($product->hasAnyOption())
                                                            @foreach ($product->options as $option)
                                                            <span>{{ $option->name }}:
                                                                <span>{{ $option->values->implode('label', ', ') }}</span></span>
                                                            @endforeach
                                                            @endif
                                                        </div> <br>
                                                    </td>
                                                    <td>
                                                        <p class="f-fallback">
                                                            {{ $product->unit_price->convert($order->currency, $order->currency_rate)->format($order->currency) }}
                                                        </p>
                                                    </td>
                                                    <td>
                                                        <p class="f-fallback"> <span> {{ intl_number($product->qty) }}
                                                                {{$product->unit }}
                                                                @if($product->width + $product->length > 0)
                                                                ({{ intl_number($product->width) }} X
                                                                {{ intl_number($product->length) }})
                                                                @endif
                                                            </span></p>
                                                    </td>
                                                    <td class="align-right">
                                                        <p class="f-fallback">
                                                            {{ $product->line_total->convert($order->currency, $order->currency_rate)->format($order->currency) }}
                                                        </p>
                                                    </td>
                                                </tr>
                                                @endforeach

                                                <tr>

                                                    <td class="purchase_footer" valign="middle" colspan="3">
                                                        <p class="f-fallback purchase_total purchase_total--label">
                                                            {{ trans('storefront::account.view_order.subtotal') }}</p>
                                                    </td>
                                                    <td class="purchase_footer" valign="middle">
                                                        <p class="f-fallback purchase_total">
                                                            {{ $order->sub_total->convert($order->currency, $order->currency_rate)->format($order->currency) }}
                                                        </p>
                                                    </td>
                                                </tr>
                                                @if ($order->hasCoupon())
                                                <tr>

                                                    <td colspan="3">
                                                        <p class="f-fallback purchase_total purchase_total--label">
                                                            {{ trans('storefront::account.view_order.coupon') }} <span
                                                                class="coupon-code">{{ $order->coupon->code }}</span>)
                                                        </p>
                                                    </td>
                                                    <td>
                                                        <p class="f-fallback purchase_total">
                                                            &#8211;{{ $order->discount->convert($order->currency, $order->currency_rate)->format($order->currency) }}
                                                        </p>
                                                    </td>
                                                </tr>
                                                @endif
                                                <tr>

                                                    <td colspan="3">
                                                        <p class="f-fallback purchase_total purchase_total--label">
                                                            {{ $order->shipping_method }}</p>
                                                    </td>
                                                    <td>
                                                        <p class="f-fallback purchase_total">
                                                            {{ $order->shipping_cost->convert($order->currency, $order->currency_rate)->format($order->currency) }}
                                                        </p>
                                                    </td>
                                                </tr>
                                                <tr>

                                                    <td colspan="3">
                                                        <p class="f-fallback purchase_total purchase_total--label">
                                                            {{ trans('storefront::invoice.total') }}
                                                        </p>
                                                    </td>
                                                    <td>
                                                        <p class="f-fallback purchase_total">
                                                            {{ $order->total->convert($order->currency, $order->currency_rate)->format($order->currency) }}
                                                        </p>
                                                    </td>
                                                </tr>

                                            </table>


                                            <table class="address" width="100%" cellpadding="0" cellspacing="15"
                                                role="presentation">
                                                <tr>
                                                    <td width="50px">
                                                        <h2>Alamat Penagihan</h2>
                                                    </td>
                                                    <td width="50px">
                                                        <h2>Alamat Pengiriman</h2>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <p class="f-fallback">
                                                            {{ $order->billing_full_name }}
                                                            <br>
                                                            {{ $order->billing_address_1 }}
                                                            <br>
                                                            {{ $order->billing_address_2 }}
                                                            <br>
                                                            {{ $order->billing_city }}, {{ $order->billing_state_name }}
                                                            {{ $order->billing_zip }}
                                                            <br>
                                                            {{ $order->billing_country_name }} </p>
                                                    </td>
                                                    <td>
                                                        <p class="f-fallback">
                                                            {{ $order->shipping_full_name }}
                                                            <br>
                                                            {{ $order->shipping_address_1 }}
                                                            <br>
                                                            {{ $order->shipping_address_2 }}
                                                            <br>
                                                            {{ $order->shipping_city }},
                                                            {{ $order->shipping_state_name }} {{ $order->shipping_zip }}
                                                            <br>
                                                            {{ $order->shipping_country_name }}</p>
                                                    </td>
                                                </tr>
                                            </table>
                                            <p class="f-fallback sub align-center">
                                                </br>
                                                mail dibuat secara otomatis. Mohon tidak mengirimkan balasan ke email
                                                ini</p>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <table class="email-footer" align="center" width="570" cellpadding="0" cellspacing="0"
                                role="presentation">
                                <tr>
                                    <td class="content-cell" align="center">
                                        <p class="f-fallback sub align-center">Jika butuh bantuan, gunakan halaman <a
                                                href="https://www.eling.co.id/contact">Contact</a></p>
                                        <p class="f-fallback sub align-center">
                                            &copy; 2020 <a href="https://www.eling.co.id">eling.co.id</a> | PT Mitsindo
                                            Visual Pratama. All rights reserved.
                                        </p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>

</html>