<?php

namespace Modules\User\Entities;

use Modules\Order\Entities\Order;
use Modules\User\Admin\UserTable;
use Modules\Review\Entities\Review;
use Illuminate\Auth\Authenticatable;
use Modules\Product\Entities\Product;
use Modules\Company\Entities\Company;
use Modules\User\Repositories\Permission;
use Cartalyst\Sentinel\Users\EloquentUser;
use Cartalyst\Sentinel\Laravel\Facades\Activation;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Support\Str;
use Modules\User\Entities\UserInfo;
use Modules\User\Admin\VerifyTable;
use Modules\Media\Entities\File;
use Modules\Media\Eloquent\HasMedia;

class User extends EloquentUser implements AuthenticatableContract
{
    use Authenticatable;
    use HasMedia;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['last_login'];

    protected $fillable = [
        'email',
        'password',
        'last_name',
        'first_name',
        'permissions',
        'company_id',
        'position',
        'google2fa_secret',
        'chat_admin',
        'company_name',
        'register_type',
        'status'
    ];

    const CUSTOMER = 'customer';
    const CUSTOMER_B2C = 'customer_b2c';
    const LOCAL_MERCHANT = 'local_merchant';
    const INTERNATIONAL_MERCHANT = 'international_merchant';

    const UNCOMPLETED = 'uncompleted';
    const ON_VERIFICATION = 'on_verification';
    const VERIFIED = 'verified';

    public static function registered($email)
    {
        return static::where('email', $email)->exists();
    }

    public static function findByEmail($email)
    {
        return static::where('email', $email)->first();
    }

    public static function totalCustomers()
    {
        return Role::findOrNew(setting('customer_role'))->users()->count();
    }

    /**
     * Login the user.
     *
     * @return $this|bool
     */
    public function login()
    {
        return auth()->login($this);
    }

    /**
     * Determine if the user is a customer.
     *
     * @return bool
     */

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->uuid = Str::uuid();
        });
    }

    public function isCustomer()
    {
        if ($this->hasRoleName('admin')) {
            return false;
        }

        return $this->hasRoleId(setting('customer_role'));
    }

    public function isAdmin()
    {
        if ($this->hasRoleName('admin') or $this->hasRoleName('admin content')) {
            return true;
        }

        return false;
    }

    public function firstRoles()
    {
        // if ($this->hasRoleName('admin')) {
        //     return 'admin';
        // }
        // else if ($this->hasRoleName('seller')) {
        //     return 'seller';
        // }

        if ($this->roles()->first() != null) {
            return $this->roles()->first()->name;
        } else {
            return "";
        }
    }

    /**
     * Checks if a user belongs to the given Role ID.
     *
     * @param int $roleId
     * @return bool
     */
    public function hasRoleId($roleId)
    {
        return $this->roles()->whereId($roleId)->count() !== 0;
    }

    /**
     * Checks if a user belongs to the given Role Slug.
     *
     * @param string $slug
     * @return bool
     */
    public function hasRoleSlug($slug)
    {
        return $this->roles()->whereSlug($slug)->count() !== 0;
    }

    /**
     * Checks if a user belongs to the given Role Name.
     *
     * @param string $name
     * @return bool
     */
    public function hasRoleName($name)
    {
        return $this->roles()->whereTranslationLike('name', '%' . $name . '%')->count() !== 0;
    }

    /**
     * Check if the current user is activated.
     *
     * @return bool
     */
    public function isActivated()
    {
        return Activation::completed($this);
    }

    /**
     * Get the recent orders of the user.
     *
     * @param int $take
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function recentOrders($take)
    {
        return $this->orders()->latest()->take($take)->get();
    }

    /**
     * Get the roles of the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'user_roles')->withTimestamps();
    }

    /**
     * Get the orders of the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orders()
    {
        return $this->hasMany(Order::class, 'customer_id');
    }

    /**
     * Get the wishlist of the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function wishlist()
    {
        return $this->belongsToMany(Product::class, 'wish_lists')->withTimestamps();
    }

    /**
     * Get the reviews of the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function reviews()
    {
        return $this->hasMany(Review::class, 'reviewer_id');
    }



    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * Get the full name of the user.
     *
     * @return string
     */
    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }

    /**
     * Set user's permissions.
     *
     * @param array $permissions
     * @return void
     */
    public function setPermissionsAttribute(array $permissions)
    {
        $this->attributes['permissions'] = Permission::prepare($permissions);
    }

    /**
     * Determine if the user has access to the given permissions.
     *
     * @param array|string $permissions
     * @return bool
     */
    public function hasAccess($permissions)
    {
        $permissions = is_array($permissions) ? $permissions : func_get_args();

        return $this->getPermissionsInstance()->hasAccess($permissions);
    }

    /**
     * Determine if the user has access to the any given permissions
     *
     * @param array|string $permissions
     * @return bool
     */
    public function hasAnyAccess($permissions)
    {
        $permissions = is_array($permissions) ? $permissions : func_get_args();

        return $this->getPermissionsInstance()->hasAnyAccess($permissions);
    }

    /**
     * Get table data for the resource
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function table()
    {
        return new UserTable($this->newQuery());
    }

    public function tableVerify()
    {
        $query =  $this->newQuery()->where('status', SELF::ON_VERIFICATION);
        return new VerifyTable($query);
    }

    public static function getChatAdmins()
    {
        return static::where('chat_admin', true)->get();
    }

    public function isUnCompletedAccount()
    {
        return $this->status == SELF::UNCOMPLETED;
    }

    public function isOnProcessVerification()
    {
        return $this->status == SELF::ON_VERIFICATION;
    }

    public function isCustomerType()
    {
        return $this->register_type == SELF::CUSTOMER;
    }

    public function isCustomerB2CType()
    {
        return $this->register_type == SELF::CUSTOMER_B2C;
    }

    public function getAttachment($attachment)
    {
        return $this->files->where('pivot.zone', $attachment)->first() ?: new File;
    }

    public function isLocalMerchantType()
    {
        return $this->register_type == SELF::LOCAL_MERCHANT;
    }

    public function isIntMerchantType()
    {
        return $this->register_type == SELF::INTERNATIONAL_MERCHANT;
    }


    public function completedRegisterCustomer()
    {

        $company = $this->company ?: new Company();
        if ($this->isCustomerType()) {
            $informations = $company->companyInfo;
            $documents =  $this->getCompanyDocuments($company, $informations, Company::CUSTOMER_DOC);
        }
        if ($this->isCustomerB2CType()) {
            $documents =  $this->getCompanyDocuments($company, $this->informations, ['ktp']);
        }
        if (empty($documents)) {
            return false;
        }
        return true;
    }

    private function getCompanyDocuments($company, $informations, $keys)
    {
        $documents = [];
        foreach ($keys as $key) {
            foreach ($informations as $info) {
                if ($key == $info->title) {
                    $file = $company->getAttachment($key);
                    $documents[] = [
                        'path' => $file->path,
                        'thumb' => $file->thumb,
                        'filename' => $file->filename,
                        'ext' => $file->extension,
                        'title' => $info->title,
                        'value' => $info->value,
                    ];
                    break;
                }
            }
        }
        return $documents;
    }

    public function informations()
    {
        return $this->hasMany(UserInfo::class, 'user_id');
    }

}
