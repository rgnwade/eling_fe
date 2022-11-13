<?php

namespace Modules\Company\Entities;

use Modules\Support\Eloquent\Model;

class Country extends Model
{

    public static function list()
    {
        return static::select('name', 'id')->pluck('name', 'id');
    }

}
