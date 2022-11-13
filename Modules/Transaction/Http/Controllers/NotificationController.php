<?php

namespace Modules\Transaction\Http\Controllers;

use Illuminate\Http\Request;
use Exception;
use Illuminate\Routing\Controller;
use Modules\Payment\Gateways\Veritrans;
use Modules\Transaction\Entities\Transaction;
use Modules\Order\Entities\Order;
use Modules\Order\Entities\OrderPayment;
use Modules\Cart\Facades\Cart;
use Modules\Checkout\Mail\Invoice;
use Config;
use Illuminate\Support\Facades\Mail;

class NotificationController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function __construct()
    {
        Veritrans::$serverKey = Config::get('app.MIDTRANS_SERVER_KEY');
        Veritrans::$isProduction = Config::get('app.MIDTRANS_PRODUCTION');
    }

    public function midtrans()
    {
        $vt = new Veritrans;
        $json_result = file_get_contents('php://input');
        $result = json_decode($json_result);
        if ($result) {
            $notif = $vt->status($result->order_id);
        }

        $transaction = $notif->transaction_status;
        $type = $notif->payment_type;
        $fraud = $notif->fraud_status;
        $order_id = $notif->order_id;

        if ($this->is_contain_dash($notif->order_id)) {
            $notif_order_id = explode('-', $notif->order_id);
            $order_id = $notif_order_id[0];
        }

        $data = new Transaction;
        $data->order_id = $order_id;
        $data->transaction_id = $notif->transaction_id;
        $data->payment_method = 'midtrans';
        $data->payment_type = $type;
        $data->payment_status = $transaction;
        $data->payment_total = $notif->gross_amount;
        $data->currency = $notif->currency;
        $data->message =  $json_result;
        $data->save();


        if ($transaction == 'settlement' || $transaction =='capture') {
            $order = Order::find($order_id);
            if ($order->total == $notif->gross_amount) {
                $order->status = Order::PROCESSING;
                $order->transaction_id = $data->id;
                $order->save();
                Cart::session($order->customer_id)->clear();
            }

            OrderPayment::where('order_id', $order_id)
                ->where('order_id', $order_id)
                ->where('payment_method', 'midtrans')
                ->where('amount', $notif->gross_amount)
                ->limit(1)
                ->update(['status' => 'paid']);

            $orderPayment = OrderPayment::where('order_id', $order_id)
                ->where('order_id', $order_id)
                ->where('payment_method', 'midtrans')
                ->where('amount', $notif->gross_amount)
                ->first();
            if ($orderPayment->type != 'down_payment') {
                Mail::to($order->customer_email)
                    ->send(new Invoice($order));
                $notif_receiving_emails = explode(',', setting('notif_receiving_emails'));
                foreach ($notif_receiving_emails as $notif_receiving_email) {
                    $email = preg_replace('/\s+/', '', $notif_receiving_email);
                    Mail::to($email)
                        ->send(new Invoice($order));
                }
            }
        }

        return 1;
    }

    private function is_contain_dash($str_number)
    {
        return preg_match('/^[0-9]+-[0-9]+$/i', $str_number);
    }
}
