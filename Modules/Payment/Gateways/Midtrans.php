<?php

namespace Modules\Payment\Gateways;

use  Modules\Payment\Gateways\Veritrans;
use Modules\Order\Entities\Order;
use Modules\Order\Entities\OrderPayment;
use Modules\Cart\Facades\Cart;
use Config;
use Illuminate\Support\Facades\Mail;
use Modules\Checkout\Mail\NewOrder;

class Midtrans
{
    public $label;
    public $description;

    public function __construct()
    {
        $this->label = setting('midtrans_label');
        $this->description = setting('midtrans_description');
        Veritrans::$serverKey = Config::get('app.MIDTRANS_SERVER_KEY');
        Veritrans::$isProduction = Config::get('app.MIDTRANS_PRODUCTION');
    }

    public function pay(OrderPayment $order_payment)
    {
        $redirect_url = $this->pay_process($order_payment);

        return $this->returnResponse($redirect_url);
    }

    public function pay_process(OrderPayment $order_payment)
    {
        $vt = new Veritrans;

        $gross_amount =  $order_payment->amount->amount();

        $transaction_details = array(
            'order_id'       => $order_payment->order_id.'-'.$order_payment->id,
            'gross_amount'   => $gross_amount
        );

        $url_finish = url('account/orders?transaction_status=settlement&order_id=' . $order_payment->order_id);
        $callbacks = array(
            'finish'          =>  $url_finish
        );

        // Populate customer's Info
        $customer_details = array(
            'first_name'            => $order_payment->order->customer_first_name,
            'last_name'             => $order_payment->order->customer_last_name,
            'email'                 => $order_payment->order->customer_email,
            'phone'                 => $order_payment->order->customer_phone,
        );

        $transaction_data = array(
            'payment_type'          => 'vtweb',
            'vtweb'                         => array(
                //'enabled_payments'    => [],
                'credit_card_3d_secure' => true
            ),
            'transaction_details' => $transaction_details,
            'customer_details'   => $customer_details,
            'finish'          =>  $url_finish,
            'callbacks'   => $callbacks,

        );

         $vtweb_url = $vt->vtweb_charge($transaction_data);

        try {
            $vtweb_url = $vt->vtweb_charge($transaction_data);
            return  $vtweb_url;
        } catch (Exception $e) {
            return $e->getMessage;
        }
    }

    public function purchase(Order $order)
    {
        $notif_receiving_emails = explode(',', setting('notif_receiving_emails'));
        foreach ($notif_receiving_emails as $notif_receiving_email) {
            $email = preg_replace('/\s+/', '', $notif_receiving_email);
            Mail::to($email)
                ->send(new NewOrder($order));
        }
        $redirect_url = $this->process($order);

        return $this->returnResponse($redirect_url);
    }

    public function process(Order $order)
    {
        $vt = new Veritrans;

        if ((!empty(Cart::paymentTerm()->down_payment_amount)) && Cart::paymentTerm()->down_payment_amount->amount() > 0) {
            $gross_amount = Cart::paymentTerm()->down_payment_amount->amount();
        } else {
            $gross_amount =  Cart::total()->convertToCurrentCurrency()->round()->amount();
        }

        $transaction_details = array(
            'order_id'          => $order->id,
            'gross_amount'  => $gross_amount
        );

        $url_finish = url('account/orders?transaction_status=settlement&order_id=' . $order->id);
        $callbacks = array(
            'finish'          =>  $url_finish
        );

        // Populate customer's Info
        $customer_details = array(
            'first_name'            => $order->customer_first_name,
            'last_name'             =>  $order->customer_last_name,
            'email'                     => $order->customer_email,
            'phone'                     => $order->customer_phone,
            );
        // Data yang akan dikirim untuk request redirect_url.
        // Uncomment 'credit_card_3d_secure' => true jika transaksi ingin diproses dengan 3DSecure.
        $transaction_data = array(
            'payment_type'          => 'vtweb',
            'vtweb'                         => array(
                //'enabled_payments'    => [],
                'credit_card_3d_secure' => true
            ),
            'transaction_details'=> $transaction_details,
            'customer_details'   => $customer_details,
            'finish'          =>  $url_finish,
            'callbacks'   => $callbacks,

        );

        try
        {
            $vtweb_url = $vt->vtweb_charge($transaction_data);
             return  $vtweb_url;
        }
        catch (Exception $e)
        {
            return $e->getMessage;
        }
    }

     private function returnResponse($response)
    {
        return new class($response) {
            private $response;

            public function __construct($response)
            {
                $this->response = $response;
            }

            public function isRedirect()
            {
                return true;
            }

            public function isSuccessful()
            {
                return false;
            }

            public function getRedirectUrl()
            {
                return $this->response;
            }
        };
    }
}
