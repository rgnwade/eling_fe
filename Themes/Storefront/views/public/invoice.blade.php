<!DOCTYPE html>
<html lang="id">

<head>
    <title>Invoice</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        * {
            box-sizing: border-box;
            -webkit-box-sizing: border-box;
        }

        @media print {
            body {
                padding-top: 0;
            }

            #action-area {
                display: none;
            }
        }

        @media screen and (min-width: 1025px) {
            .btn-download {
                display: none !important;
            }

            .btn-back {
                display: none !important;
            }
        }

        @media screen and (max-width: 1024px) {
            .content-area>div {
                width: auto !important;
            }

            .btn-print {
                display: none !important;
            }
        }

        @media screen and (max-width: 720px) {
            .content-area>div {
                width: auto !important;
            }
        }

        @media screen and (max-width: 420px) {
            .content-area>div {
                width: 790px !important;
            }
        }

        @media screen and (max-width: 430px) {
            .content-area {
                transform: scale(0.59) translate(-35%, -35%)
            }

            .content-area>div {
                width: 720px !important;
            }

            .btn-print {
                display: none !important;
            }
        }

        @media screen and (max-width: 380px) {
            .content-area {
                transform: scale(0.45) translate(-58%, -62%);
            }

            .content-area>div {
                width: 790px !important;
            }

            .btn-print {
                display: none !important;
            }
        }

        @media screen and (max-width: 320px) {
            .content-area>div {
                width: 700px !important;
            }
        }
    </style>
</head>

<body
    style="font-family: open sans, tahoma, sans-serif; margin: 0; -webkit-print-color-adjust: exact; padding-top: 60px;">

    <div id="action-area">
        <div id="navbar-wrapper"
            style="padding: 12px 16px;font-size: 0;line-height: 1.4; box-shadow: 0 -1px 7px 0 rgba(0, 0, 0, 0.15); position: fixed; top: 0; left: 0; width: 100%; background-color: #FFF; z-index: 100;">
            <div style="width: 50%; display: inline-block; vertical-align: middle; font-size: 12px;">
                <div class="btn-back" onclick="window.close();">
                <img src="{{url('/invoice')}}/back.png" width="20px" alt="Back"
                        style="display: inline-block; vertical-align: middle;" />
                    <span
                        style="display: inline-block; vertical-align: middle; margin-left: 16px; font-size: 16px; font-weight: bold; color: rgba(49, 53, 59, 0.96);">Invoice</span>
                </div>
            </div>
            <div style="width: 50%; display: inline-block; vertical-align: middle; font-size: 12px; text-align: right;">
                <a class="btn-download" href="javascript:window.print()"
                    style="display: inline-block; vertical-align: middle;">
                    <img src="{{url('/invoice')}}/download.png" alt="Download" width="20px" ; />
                </a>
                <a class="btn-print" href="javascript:window.print()"
                    style="height: 100%; display: inline-block; vertical-align: middle;">
                    <button id="print-button"
                        style="border: none; height: 100%; cursor: pointer;padding: 8px 40px;border-color: #EA1B25;border-radius: 8px;background-color: #EA1B25;margin-left: 16px;color: #fff;font-size: 12px;line-height: 1.333;font-weight: 700;">Cetak</button>
                </a>
            </div>
        </div>
    </div>


    <div class="content-area">

        <div style="background: center no-repeat; background-size: contain; margin: auto; width: 790px;">

            <table width="100%" cellspacing="0" cellpadding="0"
                style="width: 100%; padding: 25px 32px; color: #343030;">
                <tr>
                    <td>
                        <table width="100%" cellspacing="0" cellpadding="0"
                            style="padding-bottom: 20px; border-bottom: thin dashed #cccccc;">
                            <tr>
                                <td style="width: 57%; vertical-align: top;">
                                    <table width="100%" cellspacing="0" cellpadding="0">
                                        <tr>
                                            <td colspan="2">
                                                <img src="{{$logo}}" alt="Eling"
                                                    style="margin-bottom: 15px; width: 165px;">
                                            </td>
                                        </tr>

                                        <tr>
                                            <td colspan="2" style="font-size: 12px;">
                                                <span style="font-weight: 600">  {{ trans('order::invoice.invoice_number') }}</span> : <span
                                                    style="color: #474242; font-weight: 600;"> {{ $order->id }}</span>
                                            </td>
                                        </tr> 
                                        <tr>
                                            <td colspan="2" style="font-size: 12px;">
                                                <span style="font-weight: 600"> {{ trans('order::invoice.date') }}</span> : <span
                                                    style="color: #474242; font-weight: 600;">  {{ $order->created_at->format('d/m/Y') }}</span>
                                            </td>
                                        </tr>


                                    </table>
                                </td>
                                <td style="width: 43%; vertical-align: top; padding-left: 30px;">
                                    <table width="100%" cellspacing="0" cellpadding="0">
                                        <tr>
                                            <td style="font-weight: 600; font-size: 12px;padding-bottom: 8px;">
                                                {{ trans('order::invoice.shipping_address') }} :</td>
                                        </tr>
                                        <tr>
                                            <td style="font-size: 12px; padding-bottom: 20px;">
                                                <span
                                                    style="margin-bottom: 3px; font-weight: 600; display: block;">
                                                    {{ $order->customer_email}}<br>
                                                    {{ $order->shipping_full_name }}</span>
                                                <div>
                                                    {{ $order->shipping_address_1 }}  <br> {{ $order->shipping_address_2 }}  <span>{{ $order->district }}, {{ $order->shipping_city }}, {{ $order->shipping_state }}<br>
                                                        {{ $order->shipping_zip }}<br>
                                                    {{$order->customer_phone}}
                                                </div>
                                            </td>
                                        </tr>

                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>

                <tr>
                    <td>
                        <table width="100%" cellspacing="0" cellpadding="0"
                            style="border: thin dashed rgba(0, 0, 0, 0.34); border-radius: 4px; color: #343030; margin-top: 20px;">
                            <tr style="background-color: rgba(242, 242, 242, 0.74); font-size: 14px; font-weight: 600;">
                                <td style="padding: 10px 15px;">  {{ trans('order::invoice.product') }}</td>
                                <td style="padding: 10px 15px; text-align: center;"> {{ trans('order::invoice.amount') }}</td>
                                <td style="padding: 10px 15px; text-align: center; white-space: nowrap;"> {{ trans('order::invoice.price') }}</td>
                                <td style="padding: 10px 15px; text-align: right;"> {{ trans('order::invoice.line_total') }}</td>
                            </tr>

                            @foreach($companyOrders as $companyOrder)
                            <tr style="font-size: 12px;">
                                <td colspan="4" style="padding: 15px 15px 0px 15px;">
                                    <strong> {{ trans('order::invoice.seller') }} : {{$companyOrder->company->name}} </strong>
                                </td>
                            </tr>
                            <?php 
                    
                            $total_option = 0;
                            ?>

                            @foreach ($companyOrder->items as $item)
                                <tr style="font-size: 12px;">
                                    <td width="330" style="padding: 15px;">
                                        {{ $item->name }}
                                        @if ($item->hasAnyOption())
                                        <br>
                                        @foreach ($item->options as $option)
                                        <span>
                                            {{ $option->name }}:
                                            <span>{{ $option->values->implode('label', ', ') }}</span>
                                        </span>
                                        <?php  $total_option = $total_option + $option->totalOptionsPrice()->amount();  ?>
                                        @endforeach
                                        @endif
                                    </td>
                                    <td valign="top" style="padding: 15px; text-align: center;">
                                        {{ $item->qtyRemarks() }}
                                    </td>
                                    <td valign="top" style="padding: 15px; white-space: nowrap; text-align: left;">
                                        {{ $item->unit_price_before_discount->format($order->currency) }} 
                                        @if($item->unit_discount->amount() > 0) 
                                        - {{ $item->unit_discount->format($order->currency) }} 
                                        (disc)
                                        @endif
                                    </td>
                                    <td valign="top" style="padding: 15px; white-space: nowrap; text-align: right;">
                                        {{ $item->line_total->format($order->currency) }}
                                    </td>
                                </tr>
                            @endforeach
                            @if($companyOrder->company->is_tax_active)
                           <tr style="font-size: 12px;">
                                <td colspan="2"></td>
                                <td style="padding: 0px 15px 15px 15px;">{{ trans('order::invoice.subtotal_before_tax') }}</td>
                                <td style="padding-right: 10px;  text-align: right;">
                                    <?php $before_ppn =  (100/110)*($companyOrder->sum_line_total->amount() - $total_option); 
                                          $ppn  = $before_ppn * (10/100); ?>
                                    @rupiah( $before_ppn)
                                </td>
                            </tr>
                            <tr style="font-size: 12px;">
                                <td colspan="2"></td>
                                <td style="padding: 0px 15px 15px 15px;">{{ trans('order::invoice.tax') }}</td>
                                <td style="padding: 0px 15px 15px 15px; text-align: right;">
                                    @rupiah($ppn)
                                </td>
                            </tr>
                            @endif
                            @if($total_option > 0)
                            <tr style="font-size: 12px;">
                                <td colspan="2"></td>
                                <td style="padding: 0px 15px 15px 15px;">{{ trans('order::invoice.insurance') }}</td>
                                <td style="padding: 0px 15px 15px 15px; text-align: right;">
                                    @rupiah($total_option) </td>
                            </tr>
                            @endif
                            <tr style="font-size: 12px;">
                                <td colspan="2"></td>
                                <td style="padding: 0px 15px 15px 15px;"><b>{{ trans('order::invoice.subtotal') }}</b></td>
                                <td style="padding: 0px 15px 15px 15px; text-align: right;">
                                    <b> {{$companyOrder->sum_line_total->format($order->currency)}} </b></td>
                            </tr>
                            <tr>
                                <td colspan="5" style="padding: 0 15px;">
                                    <div style="border-bottom: thin solid #e0e0e0"></div>
                                </td>
                            </tr>
                            @endforeach
                        </table>
                    </td>
                </tr>

                <tr>
                    <td>
                        <table width="100%" cellspacing="0" cellpadding="0">
                            <tr>
                                <td style="width: 50%;"></td>
                                <td style="width: 50%;">
                                    <table width="100%"
                                        style="width: 430px; margin-top: 15px; padding: 15px; border-radius: 4px; border: thin dashed #cccccc; font-size: 12px; font-weight: 600;">
                                        <tr style="font-weight: normal;">
                                            <td style="padding-bottom: 10px;">
                                                {{ trans('order::invoice.subtotal') }}
                                            </td>
                                            <td
                                                style="padding-bottom: 10px;text-align: right; white-space: nowrap; vertical-align: top;">
                                                {{ $order->sub_total->format($order->currency) }}</td>
                                        </tr>
                                        
                                        <tr style="font-weight: normal;">
                                            <td style="padding-bottom: 10px;">
                                                {{ $order->shipping_method }} ({{ trans('order::invoice.weight') }} : {{$order->totalWeightShipping()}} Kg)
                                            </td>
                                            <td
                                                style="padding-bottom: 10px;text-align: right; white-space: nowrap; vertical-align: top;">
                                                {{ $order->shipping_cost->format($order->currency) }}</td>
                                        </tr>
                                        @if ($order->hasCoupon())
                                        <tr style="font-weight: normal;">
                                            <td style="padding-bottom: 10px;">
                                                {{ trans('order::invoice.coupon') }}
                                                <span
                                                    style="border: thin solid #EA1B25; border-radius: 4px; color: #EA1B25; font-size: 10px; padding: 4px 5px; margin-left: 3px; display: inline-block; vertical-align: middle;">
                                                    {{ $order->coupon->code }}

                                                </span>
                                            </td>
                                            <td
                                                style="padding-bottom: 10px;text-align: right; white-space: nowrap; vertical-align: top;">
                                                &#8211; {{ $order->discount->format($order->currency) }}</td>
                                        </tr>
                                        @endif
                                        
                                        <tr style="font-size: 12px;">
                                            <td style="border-top: thin solid #e0e0e0; padding-top: 10px;">
                                                {{ trans('order::invoice.total') }} </td>
                                            <td
                                                style="border-top: thin solid #e0e0e0; padding-top: 10px; text-align: right; white-space: nowrap;">
                                                {{ $order->total->format($order->currency) }}</td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>

                <!-- refactor div float left and right in case order is kelontong -->
                <!-- total invoice -->

            </table>
        </div>
        </td>
        </tr>
        </table>
    </div>
    </div>

    <script type="text/javascript">
        var _cf = _cf || []; _cf.push(['_setFsp', true]);  _cf.push(['_setBm', true]);  _cf.push(['_setAu', '/assets/8cd9cc69ui176505ff206335c6b361']); 
    </script>
    <script type="text/javascript" src="/assets/8cd9cc69ui176505ff206335c6b361"></script>
</body>

<script src="jquery.min.js" type="text/javascript"></script>
<script src="jquery.js" type="text/javascript"></script>

<script type="text/javascript">
    jQuery(document).ready(function (event) {

        var qrcode = new QRCode("invoice_qr", {
            text: "",
            width: 200,
            height: 200,
            colorDark: "#000000",
            colorLight: "#ffffff",
            correctLevel: QRCode.CorrectLevel.H
        });

        $('#invoice_qr').on('contextmenu', 'img', function (e) {
            return false;
        });
    });
</script>

</html>