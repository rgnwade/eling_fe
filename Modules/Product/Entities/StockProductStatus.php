<?php

namespace Modules\Product\Entities;

use Modules\Support\Eloquent\Model;

class StockProductStatus extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'stock_product_status';
    protected $fillable = ['name'];


    public static function list()
    {
        return static::select('name', 'id')->pluck('name', 'id');
    }
}
