<?php

namespace Modules\Order\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Modules\Order\Entities\Order;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Mail;
use Modules\Order\Mail\OrderStatusChanged;
use Modules\Order\Entities\OrderPayment;


class OrderStatusController extends Controller
{
    /**
     * Update the specified resource in storage.
     *
     * @param \Modules\Order\Entities\Order $request
     * @return \Illuminate\Http\Response
     */
    public function update(Order $order)
    {
        $order->update(['status' => request('status')]);
        
        if (request('status') == Order::CANCELED) {
            OrderPayment::where('order_id', $order->id)
                ->where('status', '!=', OrderPayment::status_paid)
                ->update(['status' => OrderPayment::status_canceled]);
        }

        $message = trans('order::messages.status_updated');

        if (setting('order_status_email')) {
            Mail::to($order->customer_email)
                ->send(new OrderStatusChanged($order));
        }

        return $message;
    }

    public function updateBasic(Order $order)
    {
        $order->update(['no_resi' => request('no_resi')]);
        $message = trans('order::messages.no_resi_updated');
        return $message;
    }
}
