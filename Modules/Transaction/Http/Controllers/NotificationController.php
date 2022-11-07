<?php

namespace Modules\Transaction\Http\Controllers;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Routing\Controller;
use  Modules\Payment\Gateways\Veritrans;
use Modules\Transaction\Entities\Transaction;
use Modules\Order\Entities\Order;
use Modules\Cart\Facades\Cart;
use Config;

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
        if($result){
        $notif = $vt->status($result->order_id);
        }

        $transaction = $notif->transaction_status;
        $type = $notif->payment_type;
        $order_id = $notif->order_id;
        $fraud = $notif->fraud_status;

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
        

        if ($transaction == 'settlement'){
            $order = Order::find($order_id);
            if($order->total == $notif->gross_amount){
                $order->status = Order::PROCESSING;
                $order->transaction_id = $data->id;
                $order->save();
                Cart::session($order->customer_id)->clear();
            }
        } 

        return 1;
             

        // if ($transaction == 'capture') {
        //   // For credit card transaction, we need to check whether transaction is challenge by FDS or not
        //   if ($type == 'credit_card'){
        //     if($fraud == 'challenge'){
        //       // TODO set payment status in merchant's database to 'Challenge by FDS'
        //       // TODO merchant should decide whether this transaction is authorized or not in MAP
        //       echo "Transaction order_id: " . $order_id ." is challenged by FDS";
        //       } 
        //       else {
        //       // TODO set payment status in merchant's database to 'Success'
        //       echo "Transaction order_id: " . $order_id ." successfully captured using " . $type;
        //       }
        //     }
        //   }
         
        //   else if($transaction == 'pending'){
        //   // TODO set payment status in merchant's database to 'Pending'
        //   echo "Waiting customer to finish transaction order_id: " . $order_id . " using " . $type;
        //   } 
        //   else if ($transaction == 'deny') {
        //   // TODO set payment status in merchant's database to 'Denied'
        //   echo "Payment using " . $type . " for transaction order_id: " . $order_id . " is denied.";
        // }
    }
}
