<?php

namespace Modules\Order\Entities;

use Modules\Option\Entities\Option;
use Illuminate\Database\Eloquent\Model;
use Modules\Option\Entities\OptionValue;
use Modules\Support\Money;
class OrderProductOption extends Model
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
    protected $with = ['option', 'values'];

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    public function option()
    {
        return $this->belongsTo(Option::class)->withTrashed();
    }

    public function values()
    {
        return $this->belongsToMany(OptionValue::class, 'order_product_option_values')
            ->using(OrderProductOptionValue::class)
            ->withPivot('price');
    }

    public function totalOptionsPrice()
    {
        $total = 0;
        foreach ($this->values as $value) {
            $total =  $total + $value->pivot->price->amount();
        }
        return Money::inDefaultCurrency($total);
    }

    public function getNameAttribute()
    {
        return $this->option->name;
    }

    public function storeValues($product, $values)
    {
        $values = $values->mapWithKeys(function (OptionValue $value) use ($product) {
            return [$value->id => [
                'price' => $value->priceForProduct($product)->amount(),
            ]];
        });

        $this->values()->attach($values->all());
    }
}
