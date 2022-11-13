<?php

namespace Modules\Company\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Company\Entities\Company;

class BankAccount extends Model
{
    protected $fillable = [
        'beneficiary_bank',
        'beneficiary_name',
        'beneficiary_account',
        'swift_code',
        'bank_address',
        'company_id',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }
}
