<?php

namespace Modules\Core\Entities;
use Modules\User\Entities\User;
use Modules\Core\Admin\LogTable;


use Modules\Support\Eloquent\Model;

class Log extends model
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function table()
    {
        return new LogTable($this->with('user'));
    }

}
