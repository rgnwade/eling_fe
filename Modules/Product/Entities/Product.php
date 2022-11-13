<?php

namespace Modules\Product\Entities;

use Modules\Support\Money;
use Modules\Media\Entities\File;
use Modules\Tax\Entities\TaxClass;
use Modules\Option\Entities\Option;
use Modules\Review\Entities\Review;
use Modules\Support\Eloquent\Model;
use Modules\Media\Eloquent\HasMedia;
use Modules\Meta\Eloquent\HasMetaData;
use Modules\Support\Search\Searchable;
use Modules\Category\Entities\Category;
use Modules\Product\Admin\ProductTable;
use Modules\Product\Admin\ProductVendorTable;
use Modules\Product\Admin\ProductRequestTable;
use Modules\Support\Eloquent\Sluggable;
use Modules\Support\Eloquent\Translatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Attribute\Entities\ProductAttribute;
use Modules\Company\Entities\Company;
use Modules\Currency\Entities\CurrencyRate;
use Illuminate\Support\Facades\DB;

class Product extends Model
{

    const status_reviewing = 1;
    const DEFAULT_PRICE = 0;
    const DEFAULT_MANAGE_STOCK = false;
    const DEFAULT_IN_STOCK = true;
    const DEFAULT_IS_ACTIVE = false;
    const DEFAULT_VENDOR_PRODUCT_STATUS = 1;
    const VIDEOTRON_CATEGORY = '5';
    const M2 = 'M2';

    use Translatable,
        Searchable,
        Sluggable,
        HasMedia,
        HasMetaData,
        SoftDeletes;

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = ['translations'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'tax_class_id',
        'vendor_product_status_id',
        'stock_product_status_id',
        'price_formula',
        'vendor_currency',
        'company_id',
        'slug',
        'sku',
        'price',
        'special_price',
        'special_price_start',
        'special_price_end',
        'manage_stock',
        'manage_stock',
        'qty',
        'weight',
        'length',
        'height',
        'width',
        'in_stock',
        'is_active',
        'is_lkpp',
        'lkpp_id',
        'new_from',
        'new_to',
        'vendor_price',
        'minimum_order',
        'unit'
    ];

    protected $appends = ['cabinet_length', 'cabinet_width', 'cabinet_depth', 'brand_name'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'manage_stock' => 'boolean',
        'in_stock' => 'boolean',
        'is_active' => 'boolean',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'special_price_start',
        'special_price_end',
        'new_from',
        'new_to',
        'start_date',
        'end_date',
        'deleted_at',
    ];

    /**
     * The attributes that are translatable.
     *
     * @var array
     */
    protected $translatedAttributes = ['name', 'description', 'specification', 'short_description'];

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
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($product) {
            $product->selling_price = $product->getSellingPrice();
        });

        static::saved(function ($product) {
            if (!empty(request()->all())) {
                $product->saveRelations(request()->all());
            }
            DB::table('products')
            ->where('id', $product->id)
            ->update(['keyword' =>  $product->keyword()]);
        });

        static::addActiveGlobalScope();
    }

    public  function keyword()
    {

        if ($this->merkName()) {
            return  $this->merkName() . " " . $this->name;
        }
        return  $this->name;
    }

    public static function newArrivals($limit)
    {
        return static::forCard()
            ->latest()
            ->take($limit)
            ->get();
    }

    public static function list($ids = [])
    {
        return static::withName()
            ->whereIn('id', $ids)
            ->select('id')
            ->get()
            ->mapWithKeys(function ($product) {
                return [$product->id => $product->name];
            });
    }

    public function scopeForCard($query)
    {
        $query->withName()
            ->withBaseImage()
            ->withPrice()
            ->withCount('options')
            ->addSelect([
                'products.id',
                'slug',
                'in_stock',
                'new_from',
                'new_to',
                'minimum_order',
            ]);
    }

    public function scopeWithPrice($query)
    {
        $query->addSelect([
            'price',
            'special_price',
            'selling_price',
            'special_price_start',
            'special_price_end',
        ]);
    }

    public function scopeWithName($query)
    {
        $query->with('translations:id,product_id,locale,name');
    }

    public function scopeWithBaseImage($query)
    {
        $query->with(['files' => function ($q) {
            $q->wherePivot('zone', 'base_image');
        }]);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'product_categories');
    }

    public function taxClass()
    {
        return $this->belongsTo(TaxClass::class)->withDefault();
    }


    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function attributes()
    {
        return $this->hasMany(ProductAttribute::class);
    }

    public function merk()
    {
        return $this->hasOne(ProductAttribute::class)->where('attribute_id', 1);
    }

    public function videotronInfo()
    {
        return $this->hasOne(ProductVideotron::class);
    }

    public function isVideotron()
    {
        return !empty($this->videotronInfo);
    }

    public function multiple()
    {
        if (!$this->isVideotron()) {
            return 1;
        }
        $m2  =  $this->videotronInfo->cabinet_length * $this->videotronInfo->cabinet_width;
        return $m2;
    }



    public function merkName()
    {
        if (!empty($this->merk()) && !empty($this->merk->merkName)) {
            return $this->merk->merkName->value;
        }
        return '';
    }


    public function options()
    {
        return $this->belongsToMany(Option::class, 'product_options')
            ->orderBy('position')
            ->withTrashed();
    }

    public function relatedProducts()
    {
        return $this->belongsToMany(static::class, 'related_products', 'product_id', 'related_product_id');
    }

    public function upSellProducts()
    {
        return $this->belongsToMany(static::class, 'up_sell_products', 'product_id', 'up_sell_product_id');
    }

    public function crossSellProducts()
    {
        return $this->belongsToMany(static::class, 'cross_sell_products', 'product_id', 'cross_sell_product_id');
    }

    public function filter($filter)
    {
        return $filter->apply($this);
    }

    /**
     * Get the selling price of the product.
     *
     * @return int
     */
    public function getSellingPrice()
    {
        if ($this->hasSpecialPrice()) {
            return $this->special_price->amount();
        }

        return $this->price->amount();
    }

    public function getDiscount()
    {
        return $this->price->amount() - $this->getSellingPrice();
    }

    public function getPriceAttribute($price)
    {
        return Money::inDefaultCurrency($price);
    }

    public function getVendorPriceAttribute($vendorPrice)
    {
        return Money::inVendorCurrency($vendorPrice, $this->vendor_currency);
    }

    public function getSpecialPriceAttribute($specialPrice)
    {
        if (!is_null($specialPrice)) {
            return Money::inDefaultCurrency($specialPrice);
        }
    }

    public function getSellingPriceAttribute($sellingPrice)
    {
        return Money::inDefaultCurrency($sellingPrice);
    }

    public function getTotalAttribute($total)
    {
        return Money::inDefaultCurrency($total);
    }

    /**
     * Get the product's base image.
     *
     * @return \Modules\Media\Entities\File
     */
    public function getBaseImageAttribute()
    {
        return $this->files->where('pivot.zone', 'base_image')->first() ?: new File;
    }

    /**
     * Get product's additional images.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAdditionalImagesAttribute()
    {
        return $this->files
            ->where('pivot.zone', 'additional_images')
            ->sortBy('pivot.id');
    }

    
    public function getBrandNameAttribute()
    {
        
        return $this->merkName().' '.$this->name;
    }

    public function getAttributeSetsAttribute()
    {
        return $this->getAttribute('attributes')->groupBy('attributeSet');
    }

    public function isInStock()
    {
        return $this->in_stock;
    }

    public function isOutOfStock()
    {
        return !$this->isInStock();
    }

    public function outOfStock()
    {
        $this->update(['in_stock' => false]);
    }

    public function hasStockFor($qty)
    {
        if (!$this->manage_stock) {
            return true;
        }

        return $this->qty >= $qty;
    }

    public function hasAttribute($attribute)
    {
        return $this->getAttribute('attributes')->contains('name', $attribute->name);
    }

    public function attributeValues($attribute)
    {
        return $this->getAttribute('attributes')
            ->where('name', $attribute->name)
            ->first()
            ->values
            ->implode('value', ', ');
    }

    public function hasAnyAttribute()
    {
        return $this->getAttribute('attributes')->isNotEmpty();
    }

    public function hasAnyOption()
    {
        return $this->options->isNotEmpty();
    }

    public function hasSpecialPrice()
    {
        if (is_null($this->special_price)) {
            return false;
        }

        if ($this->hasSpecialPriceStartDate() && $this->hasSpecialPriceEndDate()) {
            return $this->specialPriceStartDateIsValid() && $this->specialPriceEndDateIsValid();
        }

        if ($this->hasSpecialPriceStartDate()) {
            return $this->specialPriceStartDateIsValid();
        }

        if ($this->hasSpecialPriceEndDate()) {
            return $this->specialPriceEndDateIsValid();
        }

        return true;
    }

    private function hasSpecialPriceStartDate()
    {
        return !is_null($this->special_price_start);
    }

    private function hasSpecialPriceEndDate()
    {
        return !is_null($this->special_price_end);
    }

    private function specialPriceStartDateIsValid()
    {
        return today() >= $this->special_price_start;
    }

    private function specialPriceEndDateIsValid()
    {
        return today() <= $this->special_price_end;
    }

    public function avgRating()
    {
        // return ceil($this->reviews->avg->rating * 2) / 2;
        return round($this->rating);
    }

    public function totalReviewsForRating($rating)
    {
        return $this->reviews->where('rating', $rating)->count();
    }

    public function percentageReviewsForStar($rating)
    {
        $totalReviews = $this->reviews->count();

        if ($totalReviews === 0) {
            return 0;
        }

        $reviewsCount = $this->totalReviewsForRating($rating);

        return round($reviewsCount / $totalReviews * 100);
    }

    public function isNew()
    {
        if ($this->hasNewFromDate() && $this->hasNewToDate()) {
            return $this->newFromDateIsValid() && $this->newToDateIsValid();
        }

        if ($this->hasNewFromDate()) {
            return $this->newFromDateIsValid();
        }

        if ($this->hasNewToDate()) {
            return $this->newToDateIsValid();
        }

        return false;
    }

    private function hasNewFromDate()
    {
        return !is_null($this->new_from);
    }

    private function hasNewToDate()
    {
        return !is_null($this->new_to);
    }

    private function newFromDateIsValid()
    {
        return today() >= $this->new_from;
    }

    private function newToDateIsValid()
    {
        return today() <= $this->new_to;
    }

    public function relatedProductList()
    {
        return $this->relatedProducts()
            ->withoutGlobalScope('active')
            ->pluck('related_product_id');
    }

    public  static function getPreview($id)
    {
        return static::with([
            'attributes.attribute.attributeSet', 'options', 'files', 'relatedProducts', 'upSellProducts',
        ])->where('id', $id)->withoutGlobalScope('active')->firstOrFail();
    }

    public function upSellProductList()
    {
        return $this->upSellProducts()
            ->withoutGlobalScope('active')
            ->pluck('up_sell_product_id');
    }

    public function crossSellProductList()
    {
        return $this->crossSellProducts()
            ->withoutGlobalScope('active')
            ->pluck('cross_sell_product_id');
    }

    public static function findBySlug($slug)
    {
        return static::with([
            'attributes.attribute.attributeSet', 'options', 'files', 'relatedProducts', 'upSellProducts',
        ])->where('slug', $slug)->firstOrFail();
    }

    /**
     * Get table data for the resource
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function table($request)
    {
        $query = $this->newQuery()
            ->withoutGlobalScope('active')
            ->withName()
            ->withBaseImage()
            ->withPrice()
            ->where('vendor_product_status_id', '!=', self::status_reviewing)
            ->addSelect(['id', 'lkpp_id', 'is_active', 'created_at', 'vendor_currency'])
            ->when($request->has('except'), function ($query) use ($request) {
                $query->whereNotIn('id', explode(',', $request->except));
            });

        return new ProductTable($query);
    }

    public function tableRequestVendor($request)
    {
        $query = $this->newQuery()
            ->withoutGlobalScope('active')
            ->withName()
            ->withBaseImage()
            ->withPrice()
            ->WithVendorProductStatus()
            ->WithCompany()
            ->where('company_id', '!=', company::eling)
            ->addSelect(['id', 'vendor_product_status_id', 'company_id', 'vendor_price', 'is_active', 'created_at', 'updated_at', 'vendor_currency'])
            ->when($request->has('except'), function ($query) use ($request) {
                $query->whereNotIn('id', explode(',', $request->except));
            });

        return new ProductRequestTable($query);
    }

    public function tableVendor($request)
    {
        $query = $this->newQuery()
            ->where('company_id', auth()->user()->company_id)
            ->withoutGlobalScope('active')
            ->withName()
            ->WithVendorProductStatus()
            ->addSelect(['id', 'vendor_product_status_id', 'vendor_price', 'is_active', 'created_at', 'vendor_currency'])
            ->when($request->has('except'), function ($query) use ($request) {
                $query->whereNotIn('id', explode(',', $request->except));
            });

        return new ProductVendorTable($query);
    }

    public function scopeWithVendorProductStatus($query)
    {
        $query->with('vendorProductStatus:id,name');
    }
    public function scopeWithCompany($query)
    {
        $query->with('company:id,name');
    }

    public function vendorProductStatus()
    {
        return $this->belongsTo(VendorProductStatus::class, 'vendor_product_status_id');
    }

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function stockProductStatus()
    {
        return $this->belongsTo(StockProductStatus::class);
    }




    /**
     * Save associated relations for the product.
     *
     * @param array $attributes
     * @return void
     */
    public function saveRelations($attributes = [])
    {
        $this->categories()->sync(array_get($attributes, 'categories', []));
        $this->upSellProducts()->sync(array_get($attributes, 'up_sells', []));
        $this->crossSellProducts()->sync(array_get($attributes, 'cross_sells', []));
        $this->relatedProducts()->sync(array_get($attributes, 'related_products', []));
    }

    /**
     * Get the indexable data array for the product.
     *
     * @return array
     */
    public function toSearchableArray()
    {
        // MySQL Full-Text search handles indexing automatically.
        if (config('scout.driver') === 'mysql') {
            return [];
        }

        $translations = $this->translations()
            ->withoutGlobalScope('locale')
            ->get(['name', 'description', 'short_description']);

        return ['id' => $this->id, 'translations' => $translations];
    }

    public function searchTable()
    {
        return 'products';
    }

    public function searchKey()
    {
        return 'id';
    }

    public function searchColumns()
    {
        return ['keyword'];
    }

    public function priceFormulas()
    {
        $vendor_price = $this->vendor_price->amount();
        $rate = CurrencyRate::currentUSD();
        $fomulas =  ProductPriceFormula::list($this->vendor_currency);
        $fomulas = $fomulas->map(function ($name, $key) use ($vendor_price, $rate) {
            $result = 0;
            eval('$result = ' . $key . ';');
            $result = round($result, -3);
            $result = Money::inDefaultCurrency($result)->format();
            return $result . " " . $name;
        });

        return $fomulas;
    }

    public function getCabinetLengthAttribute()
    {
        if ($this->isVideotron()) {
            return $this->videotronInfo->cabinet_length;
        }
        return 0;
    }

    public function getCabinetWidthAttribute()
    {
        if ($this->isVideotron()) {
            return $this->videotronInfo->cabinet_width;
        }
        return 0;
    }

    public function getCabinetDepthAttribute()
    {
        if ($this->isVideotron()) {
            return $this->videotronInfo->cabinet_depth;
        }
        return 0;
    }
}
