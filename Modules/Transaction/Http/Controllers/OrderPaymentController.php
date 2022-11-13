<?php

namespace Modules\Transaction\Http\Controllers;

use Exception;
use Illuminate\Routing\Controller;
use Modules\Order\Entities\OrderPayment;
use Modules\Payment\Facades\Gateway;

class OrderPaymentController extends Controller
{

    public function payment_midtrans($order_payment_id)
    {

        $order_payment = OrderPayment::findOrFail($order_payment_id);

        $gateway = Gateway::get('midtrans');

        try {
            $response = $gateway->pay($order_payment);

        } catch (Exception $e) {
            return redirect()->back()
                ->withError($e->getMessage());
        }

        if ($response->isRedirect()) {
            return redirect($response->getRedirectUrl());
        }

        return back()->withInput()->withError($response->getMessage());
    }


}
