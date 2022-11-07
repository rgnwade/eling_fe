<?php

namespace Modules\Page\Entities;

use Modules\Admin\Ui\AdminTable;
use Modules\Support\Eloquent\Model;
use Modules\Meta\Eloquent\HasMetaData;
use Modules\Support\Eloquent\Sluggable;
use Modules\Support\Eloquent\Translatable;
use Modules\Media\Eloquent\HasMedia;
use Modules\Media\Entities\File;
use Modules\User\Entities\User;

class Page extends Model
{
    use Translatable, Sluggable, HasMetaData, HasMedia;

    const news = 1;

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
    protected $fillable = ['slug', 'is_active','category_id', 'created_by'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * The attributes that are translatable.
     *
     * @var array
     */
    protected $translatedAttributes = ['name', 'body'];

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

        static::addActiveGlobalScope();
    }

    public static function urlForPage($id)
    {
        return static::select('slug')->firstOrNew(['id' => $id])->url();
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function url()
    {
        if (is_null($this->slug)) {
            return '#';
        }

        return localized_url(locale(), $this->slug);
    }

    /**
     * Get table data for the resource
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function table()
    {
        return new AdminTable($this->newQuery()->withoutGlobalScope('active'));
    }

    public function scopeWithBaseImage($query)
    {
        $query->with(['files' => function ($q) {
            $q->wherePivot('zone', 'base_image');
        }]);
    }

    public function getBaseImageAttribute()
    {
        return $this->files->where('pivot.zone', 'base_image')->first() ?: new File;
    }
}
