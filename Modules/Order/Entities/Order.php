<?php

namespace Modules\Order\Entities;

use Modules\Support\Money;
use Modules\Support\State;
use Modules\Support\Country;
use Modules\Tax\Entities\TaxRate;
use Illuminate\Support\Facades\DB;
use Modules\Coupon\Entities\Coupon;
use Modules\Order\Admin\OrderTable;
use Modules\Support\Eloquent\Model;
use Modules\Payment\Facades\Gateway;
use Modules\Shipping\Facades\ShippingMethod;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Order\Admin\OrderVendorTable;
use Modules\Transaction\Entities\Transaction;
use Modules\Company\Entities\Company;
use Modules\Review\Entities\Review;
use Modules\User\Entities\User;

class Order extends Model
{
    use SoftDeletes;

    const CANCELED = 'canceled';
    const COMPLETED = 'completed';
    const RECEIVED = 'received';
    const ON_HOLD = 'on_hold';
    const PENDING = 'pending';
    const PAID = 'paid';
    const PENDING_PAYMENT = 'pending_payment';
    const PROCESSING = 'processing';
    const REFUNDED = 'refunded';
    const IN_SHIPPING = 'in_shipping';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];
    protected $appends = ['payment_method_label'];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['start_date', 'end_date', 'deleted_at'];

    public static function totalSales()
    {
        $total = static::whereNotIn('status', ['canceled', 'refunded'])->sum('total');

        return Money::inDefaultCurrency($total);
    }

    public function status()
    {
        return trans("order::statuses.{$this->status}");
    }

    public function payment_term()
    {
        return trans("order::payment_terms.{$this->payment_term}");
    }

    public function payment_status()
    {
        if (empty($this->transaction) || $this->transaction->payment_status == 'pending')
            return trans("storefront::account.orders.payment_status_pending");

        if ($this->transaction->payment_status == 'settlement')
            return trans("storefront::account.orders.payment_status_success");

        return $this->transaction->status;
    }


    // public function hasShippingMethod()
    // {
    //     return ! is_null($this->shipping_method);
    // }

    public function hasCoupon()
    {
        return !is_null($this->coupon);
    }

    public function hasTax()
    {
        return $this->taxes->isNotEmpty();
    }

    public static function salesAnalytics()
    {
        return static::selectRaw('SUM(total) as total')
            ->selectRaw('COUNT(*) as total_orders')
            ->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])
            ->selectRaw('EXTRACT(DAY FROM created_at) as day')
            ->groupBy(DB::raw('EXTRACT(DAY FROM created_at)'))
            ->orderby('day')
            ->get();
    }

    public function products()
    {
        return $this->hasMany(OrderProduct::class);
    }

    public function company_orders()
    {
        return $this->hasMany(CompanyOrder::class);
    }

    public function getStatusByCompany($company_id)
    {
        return $this->company_orders->where('company_id', $company_id)->first() ?: new CompanyOrder();
    }

    public function filterByCompany($id)
    {
        return $this->products->filter(function ($order_product) use ($id) {
            return $order_product->product->company_id == $id;
        });
    }

    public function filterPaymentByCompany($id)
    {
        return $this->company_payments->filter(function ($payment) use ($id) {
            return $payment->company_id == $id;
        });
    }

    public function productsGroupByCompany()
    {
        $order_products_company = $this->products->groupBy('product.company.id');
        $order_id = $this->id;
        return  $order_products_company->map(function ($item, $key) use ($order_id) {
            $item = (object) $item;
            $currency = $item->first()->product->vendor_currency; //akan ada bug jika salah satu dari orderan menggunakan currency yang berbeda
            return  (object) [
                'company' => Company::find($key),
                'company_order' => CompanyOrder::where('company_id', $key)->where('order_id', $order_id)->first(),
                'sum_line_total' => Money::inDefaultCurrency($item->sum('line_total_without_currency')),
                'sum_line_total_vendor' => Money::inVendorCurrency($item->sum('line_total_vendor'), $currency),
                'items' =>  $item
            ];
        });
    }

    public function payments()
    {
        return $this->hasMany(OrderPayment::class);
    }

    public function paymentStatus()
    {
        $paid = $this->payments->whereIn('type',['completion_payment','full_payment'])->where('status', self::PAID)->count();
      
        if($paid > 0){
            return self::PAID;
        }
        return  self::PENDING;
    }

    public function company_payments()
    {
        return $this->hasMany(OrderPaymentCompany::class);
    }

    public function coupon()
    {
        return $this->belongsTo(Coupon::class)->withTrashed();
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function taxes()
    {
        return $this->belongsToMany(TaxRate::class, 'order_taxes')
            ->using(OrderTax::class)
            ->as('order_tax')
            ->withPivot('amount')
            ->withTrashed();
    }

    public function transaction()
    {
        return $this->hasOne(Transaction::class)->withTrashed();
    }

    public function completed()
    {
        return $this->status == SELF::COMPLETED || $this->status == SELF::RECEIVED;
    }

    public function isOnProcess()
    {
        return $this->status == SELF::PROCESSING || $this->status == SELF::IN_SHIPPING;
    }


    public function getSubTotalAttribute($subTotal)
    {
        return Money::inDefaultCurrency($subTotal);
    }

    public function getShippingCostAttribute($shippingCost)
    {
        return Money::inDefaultCurrency($shippingCost);
    }

    public function getDiscountAttribute($discount)
    {
        return Money::inDefaultCurrency($discount);
    }

    public function getTaxAttribute($tax)
    {
        return Money::inDefaultCurrency($tax);
    }

    public function getTotalAttribute($total)
    {
        return Money::inDefaultCurrency($total);
    }

    /**
     * Get the order's shipping method.
     *
     * @param string $shippingMethod
     * @return string
     */
    // public function getShippingMethodAttribute($shippingMethod)
    // {
    //     return ShippingMethod::get($shippingMethod)->label ?? '';
    // }

    /**
     * Get the order's payment method.
     *
     * @param string $paymentMethod
     * @return string
     */

    public function getPaymentMethodLabelAttribute()
    {
        return Gateway::get($this->payment_method)->label ?? '';
    }

    public function getCustomerFullNameAttribute()
    {
        return "{$this->customer_first_name} {$this->customer_last_name}";
    }

    public function getBillingFullNameAttribute()
    {
        return "{$this->billing_first_name} {$this->billing_last_name}";
    }

    public function getShippingFullNameAttribute()
    {
        return "{$this->shipping_first_name} {$this->shipping_last_name}";
    }

    public function getBillingCountryNameAttribute()
    {
        return Country::name($this->billing_country);
    }

    public function getShippingCountryNameAttribute()
    {
        return Country::name($this->shipping_country);
    }

    public function getBillingStateNameAttribute()
    {
        return State::name($this->billing_country, $this->billing_state);
    }

    public function getShippingStateNameAttribute()
    {
        return State::name($this->shipping_country, $this->shipping_state);
    }

    public function customer()
    {
        return $this->belongsTo(User::class);
    }


    public function storeProducts($cartItem)
    {
        $orderProductData = [
            'product_id' => $cartItem->product->id,
            'unit_price' => $cartItem->unitPrice()->amount(),
            'unit_price_vendor' => $cartItem->product->vendor_price->amount(),
            'qty' => $cartItem->qty,
            'weight' => $cartItem->product->weight,
            'line_total' => $cartItem->total()->amount(),
            'line_total_discount' => $cartItem->product->getDiscount() * $cartItem->qty,
            'line_total_vendor' => ($cartItem->qty * $cartItem->product->vendor_price->amount()),
            'unit' =>  $cartItem->product->unit
        ];
        if($cartItem->product->isVideotron()){
            $orderProductData =   array_merge($orderProductData, [
                'width' => $cartItem->details['width'],
                'length' => $cartItem->details['length']
            ]);
        }
        $orderProduct = $this->products()->create($orderProductData);

        $orderProduct->storeOptions($cartItem->options);
    }

    public function storeOrderCompanies($order_products_company)
    {
        $orderProduct = $this->company_orders()->create([
            'company_id' => $order_products_company->company->id,
            'total' => $order_products_company->total->amount(),
            'currency' => $order_products_company->total->currency(),
            'total_vendor' => $order_products_company->total_vendor->amount(),
            'total_vendor' => $order_products_company->total_vendor->amount(),
            'currency_vendor' => $order_products_company->total_vendor->currency(),
            'status' => CompanyOrder::STATUSES['prepared'],
            'created_by' => auth()->id()
        ]);
    }

    public function totalWeightShipping()
    {
        $dimension_to_weight_courier = intval( $this->dimension_total  / 6000);
        $weight_item_kg = $this->weight_total;
        if($dimension_to_weight_courier > $weight_item_kg){
            return $dimension_to_weight_courier;
        }
        return $weight_item_kg;
    }

    public function storePayments($payments)
    {
        $this->payments()->create($payments);
    }


    public function attachTax($cartTax)
    {
        $this->taxes()->attach($cartTax->id(), ['amount' => $cartTax->amount()->amount()]);
    }

    public function storeTransaction($response)
    {
        if (is_null($response->getTransactionReference())) {
            return;
        }

        $this->transaction()->create([
            'transaction_id' => $response->getTransactionReference(),
            'payment_method' => $this->getOriginal('payment_method'),
        ]);
    }

    /**
     * Get table data for the resource
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function table()
    {
        $query = $this->newQuery()
            ->select([
                'id',
                'customer_first_name',
                'customer_last_name',
                'customer_email',
                'currency',
                'total',
                'status',
                'created_at',
            ]);

        return new OrderTable($query);
    }
}
