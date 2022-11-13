<?php

namespace Modules\Product\Entities;

use Modules\Support\Eloquent\Model;

class VendorProductStatus extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'vendor_product_status';
    protected $fillable = ['name'];
    protected $primaryKey = 'id';


    public static function list()
    {
        return static::select('name', 'id')->pluck('name', 'id');
    }
}
