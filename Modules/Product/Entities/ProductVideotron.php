<?php

namespace Modules\Product\Entities;

use Modules\Support\Eloquent\Model;

class ProductVideotron extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'product_videotrons';
    protected $fillable = ['product_id', 'cabinet_length', 'cabinet_width', 'cabinet_depth'];


}
