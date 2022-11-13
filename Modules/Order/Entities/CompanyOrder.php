<?php

namespace Modules\Order\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Company\Entities\Company;
use Modules\Order\Admin\OrderVendorTable;
use Modules\Support\Money;

class CompanyOrder extends Model
{
    const STATUSES = [
        'prepared' => 'Prepared',
        'processing' => 'Processing',
        'ready_to_ship' => 'Ready to Ship',
        'shipping' => 'Shipping'
    ];

    protected $fillable = [
        'order_id',
        'company_id',
        'created_by',
        'total',
        'currency',
        'total_vendor',
        'currency_vendor',
        'status'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public static function validStatus()
    {
        return array_keys(self::STATUSES);
    }

    public function getFormattedTotalAttribute()
    {
        return Money::inVendorCurrency(
            $this->total,
            $this->currency
        )->format();
    }

    public function getFormattedTotalVendorAttribute()
    {
        return Money::inVendorCurrency(
            $this->total_vendor,
            $this->currency_vendor
        )->format();
    }

    public function tableVendor()
    {
        $query = $this->newQuery()
            ->join('orders', 'company_orders.order_id', '=', 'orders.id')
            ->where('orders.status', '!=', 'pending')
            ->where('company_orders.company_id', auth()->user()->company_id)
            ->select([
                'orders.id',
                'orders.customer_first_name',
                'orders.customer_last_name',
                'orders.customer_email',
                'company_orders.currency_vendor',
                'company_orders.total_vendor',
                'company_orders.status',
                'orders.created_at',
            ]);

        return new OrderVendorTable($query);
    }
}
