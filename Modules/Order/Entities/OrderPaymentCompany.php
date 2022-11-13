<?php

namespace Modules\Order\Entities;


use Modules\Support\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Company\Entities\Company;
use Modules\Media\Eloquent\HasMedia;
use Modules\Media\Entities\File;
use Carbon\Carbon;
use Modules\Support\Money;

class OrderPaymentCompany extends Model
{


    use SoftDeletes, HasMedia;

    public $timestamps = true;
    protected $guarded = [];
    protected $table = 'order_payment_company';
    protected $fillable = [
        'order_id', 'company_id', 'payment_date', 'amount', 'currency',
        'beneficiary_bank', 'beneficiary_swift', 'beneficiary_name', 'beneficiary_account',
        'sender_bank', 'sender_swift', 'sender_name', 'sender_account', 'remarks'
    ];

    protected $dates = ['payment_date'];

    public function setPaymentDateAttribute($value)
    {
        $date = Carbon::createFromFormat('d/m/Y', $value);
        $this->attributes['payment_date'] =  $date->format('Y-m-d');
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }


    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function getSenderInfoAttribute()
    {
        $bank = $this->sender_bank.' '.$this->sender_swift;
        $account = $this->sender_name.' '.$this->sender_account;
        return $bank.'<br />'.$account;
    }

    public function getBeneficiaryInfoAttribute()
    {
        $bank = $this->beneficiary_bank.' '.$this->beneficiary_swift;
        $account = $this->beneficiary_name.' '.$this->beneficiary_account;
        return $bank.'<br />'.$account;
    }

    public function getReceiptAttribute()
    {
        return $this->files->where('pivot.zone', 'receipt')->first() ?: new File;
    }

    public function getAmountAttribute($amount)
    {
        return Money::inDefaultCurrency($amount);
    }
}
