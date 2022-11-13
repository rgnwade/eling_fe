<?php

namespace Modules\Order\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Modules\Media\Entities\File;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class OrderVendorStatusChanged extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $heading;
    public $text;

    /**
     * Create a new message instance.
     *
     * @param \Modules\Order\Entities\Order $order
     * @return void
     */
    public function __construct($order, $vendor_id, $status)
    {
        app()->setLocale($order->locale);

        $this->heading = $this->getHeading();
        $this->text = $this->getText($order, $vendor_id, $status);
    }

    public function getHeading()
    {
        return trans('storefront::mail.hello', ['name' => 'Admin']);
    }

    public function getText($order, $vendor_id, $status)
    {
        return trans('order::mail.order_status_changed_text', [
            'order_id' => '<a href="'.route('admin.orders_vendor.show', ['order_id' => $order->id, 'vendor_id' => $vendor_id ]).'" >'.$order->id.'-'.$vendor_id.'</a>',
            'status' => trans("order::vendor_statuses.{$status}"),
        ]);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject(trans('order::mail.order_status_changed_subject'))
            ->view("emails.{$this->getViewName()}", [
                'logo' => File::findOrNew(setting('storefront_mail_logo'))->path,
            ]);
    }

    private function getViewName()
    {
        return 'text' . (is_rtl() ? '_rtl' : '');
    }
}
