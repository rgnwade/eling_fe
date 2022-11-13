<?php

namespace Modules\Company\Entities;

use Modules\User\Entities\User;
use Modules\Media\Entities\File;
use Modules\Support\Eloquent\Model;
use Modules\Company\Admin\CompanyTable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Media\Eloquent\HasMedia;
use Modules\Support\Eloquent\Sluggable;
use Modules\Company\Entities\Country;
use Modules\Company\Entities\BankAccount;
use Modules\Company\Entities\CompanyInfo;
use Illuminate\Support\Str;
use Auth;
use Modules\Product\Entities\Product;

class Company extends Model
{
    use SoftDeletes,
        HasMedia,
        Sluggable;

    const eling = 1;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'is_seller',
        'is_buyer',
        'is_active',
        'is_tax_active',
        'country_id',
        'address',
        'phone',
        'email',
        'director_name',
        'director_passport',
        'fta_status',
        'fta_number',
        'create_by',
        'type',
        'files[other_file]', // attachment
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'is_seller' => 'boolean',
        'is_buyer' => 'boolean',
        'is_active' => 'boolean',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * The attribute that will be slugged.
     *
     * @var string
     */
    protected $slugAttribute = 'name';

    /**
     * The "booting" method of the model.
     *
     * @return void
     */

    const CUSTOMER = 'customer';
    const LOCAL_MERCHANT = 'local_merchant';
    const INTERNATIONAL_MERCHANT = 'international_merchant';

    const CUSTOMER_DOC = ['npwp'];
    const LOCAL_MERCHANT_DOC = ['npwp', 'siup', 'nib', 'sppkp', 'pajak', 'akta'];
    const INT_MERCHANT_DOC = ['other_file'];

    const SOCIALS = ['profile', 'instagram', 'twitter', 'facebook', 'website'];


    protected static function boot()
    {
        parent::boot();

        static::saved(function ($company) {
            $company->saveRelations(request()->all());
        });
        self::creating(function ($model) {
            $model->uuid = Str::uuid();
            if (Auth::user()) $model->create_by = Auth::user()->id;
        });

        static::addActiveGlobalScope();
    }

    public function getOtherFileAttribute()
    {
        return $this->files->where('pivot.zone', 'other_file')->first() ?: new File;
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function companyInfo()
    {
        return $this->hasMany(CompanyInfo::class, 'company_id');
    }

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }

    public static function list()
    {
        return static::select('name', 'id')->pluck('name', 'id');
    }

    /**
     * Get table data for the resource
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function table()
    {
        return new CompanyTable($this->newQuery()->withoutGlobalScope('active')->with('country'));
    }

    public function type()
    {
        $type = [];
        if ($this->is_seller) {
            array_push($type, 'seller');
        }
        if ($this->is_buyer) {
            array_push($type, 'buyer');
        }
        return  implode(", ", $type);;
    }

    public function getBaseImageAttribute()
    {
        return $this->files->where('pivot.zone', 'base_image')->first() ?: new File;
    }

    public function getInfo($title)
    {
        return $this->companyInfo->where('title', $title)->first() ?: new CompanyInfo;
    }

    public function getFirstInfo($title)
    {
        return $this->companyInfo->where('title', $title)->first();
    }

    public function bankAccount()
    {
        return $this->hasOne(BankAccount::class);
    }

    public static function findBySlug($slug)
    {
        return static::where('slug', $slug)->firstOrFail();
    }

    public function getAdditionalImagesAttribute()
    {
        return $this->files
            ->where('pivot.zone', 'additional_images')
            ->sortBy('pivot.id');
    }

    public function getAttachment($attachment)
    {
        return $this->files->where('pivot.zone', $attachment)->first() ?: new File;
    }

    public function avgRating()
    {
        $average = Product::where('company_id', $this->id)
            ->where('rating', '>', 0.0)->avg('rating');
        return round($average);
    }

    public function isCustomerType()
    {
        return $this->type == SELF::CUSTOMER;
    }

    public function isLocalMerchantType()
    {
        return $this->type == SELF::LOCAL_MERCHANT;
    }

    public function isIntMerchantType()
    {
        return $this->type == SELF::INTERNATIONAL_MERCHANT;
    }

    /**
     * Save associated relations for the Company.
     *
     * @param array $attributes
     * @return void
     */
    public function saveRelations(array $attributes)
    {
        // $this->syncProducts(array_get($attributes, 'products', []));
        // $this->syncExcludeProducts(array_get($attributes, 'exclude_products', []));

        // $this->syncCategories(array_get($attributes, 'categories', []));
        // $this->syncExcludeCategories(array_get($attributes, 'exclude_categories', []));
    }
}
