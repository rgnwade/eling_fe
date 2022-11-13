<?php

namespace Modules\Checkout\Listeners;

use Swift_TransportException;
use Modules\Checkout\Mail\Invoice;
use Modules\Checkout\Mail\NewOrder;
use Modules\Checkout\Mail\WaitingPayment;
use Illuminate\Support\Facades\Mail;
use Modules\Order\Entities\OrderPayment;

class SendOrderEmails
{
    /**
     * Handle the event.
     *
     * @param \App\Events\OrderPlaced $event
     * @return void
     */
    public function handle($event)
    {
        try {
            $notif_receiving_emails = explode(',', setting('notif_receiving_emails'));
            foreach ($notif_receiving_emails as $notif_receiving_email) {
                $email = preg_replace('/\s+/', '', $notif_receiving_email);
                Mail::to($email)
                    ->send(new NewOrder($event->order));
            }

            // if (setting('invoice_email')) {
            //     Mail::to($event->order->customer_email)
            //         ->send(new Invoice($event->order));
            // }

            $payment = OrderPayment::where('order_id', $event->order->id)
                ->where('payment_method', 'bank_transfer')
                ->where('status',  OrderPayment::status_pending)->first();

            if(!empty($payment)){
                Mail::to($event->order->customer_email)
                    ->send(new WaitingPayment($payment));
            }

        } catch (Swift_TransportException $e) {
            //
        }
    }
}
