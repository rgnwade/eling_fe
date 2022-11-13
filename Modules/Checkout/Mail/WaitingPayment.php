<?php

namespace Modules\Checkout\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Modules\Media\Entities\File;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class WaitingPayment extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * The instance of the order.
     *
     * @var \Modules\Order\Entities\Order
     */
    public $payment_order;

    /**
     * Create a new message instance.
     *
     * @param \Modules\Order\Entities\Order $order
     * @return void
     */
    public function __construct($payment_order)
    {
        $this->payment_order = $payment_order;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        app()->setLocale($this->payment_order->order->locale);

        return $this->subject(trans('storefront::mail.waiting_payment_subject', ['order_id' => $this->payment_order->order_id]))
            ->view("emails.waiting_payment", [
                'logo' => File::findOrNew(setting('storefront_mail_logo'))->path,
            ]);
    }
}
