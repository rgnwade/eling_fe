<?php

namespace Modules\Cart\Http\Controllers;

use Modules\Cart\Facades\Cart;
use Illuminate\Routing\Controller;
use Modules\Shipping\Facades\ShippingMethod;
use Illuminate\Http\Request;
use Config;
use Modules\Support\Money;
use Modules\Shipping\Method;
use Modules\Shipping\RajaOngkir;
use Illuminate\Support\Facades\Redis;

class PaymentTermsController extends Controller
{

    const down_payment = '0.3';

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */

    public function setAdvance(Request $request)
    {
        $down_payment = self::down_payment;
        Cart::applyDownPayment($down_payment);

        return response()->json([
            'total' => Cart::total()->convertToCurrentCurrency()->format(),
            'down_payment_amount' => Cart::paymentTerm()->down_payment_amount->format(),
            'down_payment_percent' => (Cart::paymentTerm()->down_payment_percent * 100).'%',
            'completion_payment_amount' => Cart::paymentTerm()->completion_payment_amount->format(),
        ]);
    }

    public function setFullPayment(Request $request)
    {
        Cart::applyFullPayment();

        return response()->json([
            'total' => Cart::total()->convertToCurrentCurrency()->format(),
        ]);
    }


}
