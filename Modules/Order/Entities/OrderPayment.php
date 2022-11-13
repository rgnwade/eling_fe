<?php

namespace Modules\Order\Entities;

use Modules\Support\Money;
use Modules\Support\Eloquent\Model;
use Modules\Product\Entities\Product;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Payment\Facades\Gateway;
use Modules\Checkout\Mail\WaitingPayment;
use Modules\Checkout\Mail\Invoice;
use Modules\Checkout\Mail\PaidPayment;
use Illuminate\Support\Facades\Mail;


class OrderPayment extends Model
{

    use SoftDeletes;

    public $timestamps = true;
    protected $appends = ['payment_method_label'];

    protected $guarded = [];


    const status_pending = 'pending';
    const status_upcoming = 'upcoming';
    const status_paid = 'paid';
    const status_canceled = 'canceled';


    const STATUSES = [
        self::status_pending,
        self::status_upcoming,
        self::status_paid
    ];

    public static function boot()
    {
        parent::boot();
        self::updated(function ($model) {
            if ($model->status == self::status_pending) {
                Mail::to($model->order->customer_email)
                    ->send(new WaitingPayment($model));
            } else if ($model->status == self::status_paid) {
                Mail::to($model->order->customer_email)
                    ->send(new PaidPayment($model));
                if ($model->type != 'down_payment') {
                    $notif_receiving_emails = explode(',', setting('notif_receiving_emails'));
                    foreach ($notif_receiving_emails as $notif_receiving_email) {
                        $email = preg_replace('/\s+/', '', $notif_receiving_email);
                        Mail::to($email)
                            ->send(new Invoice($model->order));
                    }
                }
            }
        });
    }

    public function status()
    {
        return trans("order::payment_statuses.{$this->status}");
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function action()
    {
        if ($this->status == self::status_pending && $this->payment_method == 'midtrans') {
            return  [
                'title' => trans("order::orders.pay_now"),
                'url' => url('order-payment-midtrans/' . $this->id)
            ];
        }
        return '';
    }

    public function instruction()
    {
        if ($this->status == self::status_pending) {
            return setting("{$this->payment_method}_instructions");
        }
        return '';
    }

    public function getPaymentMethodLabelAttribute()
    {
        return Gateway::get($this->payment_method)->label ?? '';
    }

    public function type()
    {
        return trans("order::payment_types.{$this->type}");
    }

    public function getAmountAttribute($amount)
    {
        return Money::inDefaultCurrency($amount);
    }
}
