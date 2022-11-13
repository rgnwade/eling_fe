<?php

namespace Modules\Order\Entities;

use Modules\Support\Money;
use Modules\Support\Eloquent\Model;
use Modules\Product\Entities\Product;

class OrderProduct extends Model
{
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = ['product', 'options'];

    protected $appends = ['line_total_without_currency','unit_discount', 'unit_price_before_discount'];

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    public function hasAnyOption()
    {
        return $this->options->isNotEmpty();
    }

    /**
     * Determine if order product has been deleted.
     *
     * @return bool
     */
    public function trashed()
    {
        return $this->product->trashed();
    }

    /**
     * Store order product's options.
     *
     * @param \Illuminate\Database\Eloquent\Collection $options
     * @return void
     */
    public function storeOptions($options)
    {
        $options->each(function ($option) {
            $orderProductOption = $this->options()->create([
                'order_product_id' => $this->id,
                'option_id' => $option->id,
            ]);

            $orderProductOption->storeValues($this->product, $option->values);
        });
    }

    public function product()
    {
        return $this->belongsTo(Product::class)
            ->with('company')
            ->withoutGlobalScope('active')
            ->withTrashed();
    }

     public function company()
    {
        return $this->belongsTo(Product::class)
            ->with('company')
            ->withoutGlobalScope('active')
            ->withTrashed();
    }


    public function options()
    {
        return $this->hasMany(OrderProductOption::class);
    }

    /**
     * Get the order product's name.
     *
     * @return string
     */
    public function getNameAttribute()
    {
        return $this->product->name;
    }

    public function qtyRemarks()
    {
        
        if($this->width + $this->length > 0){
            
            return $this->qty.' '.$this->unit.' ('.$this->width.'  X '.$this->length.')';
        }
        
        return $this->qty.' '.$this->unit;
    }

    /**
     * Get the order product's slug.
     *
     * @return string
     */
    public function getSlugAttribute()
    {
        return $this->product->slug;
    }

    public function getUnitPriceAttribute($unitPrice)
    {
        return Money::inDefaultCurrency($unitPrice);
    }

    public function getLineTotalAttribute($total)
    {
        return Money::inDefaultCurrency($total);
    }

    public function getLineTotalWithoutCurrencyAttribute() //untuk menghindari bug, dimana lineTotal yang berformat money tidak bisa disum pada colection
    {
        return $this->line_total->amount();
    }

    public function unit_price_vendor()
    {

        return Money::inVendorCurrency($this->unit_price_vendor, $this->product->vendor_currency);
    }

    public function line_total_vendor()
    {
        return Money::inVendorCurrency($this->line_total_vendor, $this->product->vendor_currency);
    }

    public function getUnitDiscountAttribute()
    {
        return Money::inDefaultCurrency($this->line_total_discount / $this->qty);
    }

    public function getUnitPriceBeforeDiscountAttribute()
    {
        return Money::inDefaultCurrency($this->unit_price->amount()  + $this->unit_discount->amount());
    }

}


