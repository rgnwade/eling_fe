<?php

namespace Modules\Product\Entities;

use Modules\Support\Eloquent\Model;

class ProductPriceFormula extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'product_price_formula';
    protected $fillable = ['name', 'formula'];


    public static function list($currency = '')
    {
         $data = static::select('name', 'formula');
         if(!empty($currency)){
             $data = $data->where('currency', $currency);
         }
         return $data->pluck('name', 'formula');
    }
}
