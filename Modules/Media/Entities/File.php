<?php

namespace Modules\Media\Entities;

use Modules\Media\IconResolver;
use Modules\User\Entities\User;
use Modules\Media\Admin\MediaTable;
use Modules\Support\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class File extends Model
{
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */

    const THUMB = 'thumb_';

    protected $guarded = [];

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::deleted(function ($file) {
            Storage::disk($file->disk)->delete($file->path);
            $original_filename = substr($file->path, strpos($file->path, "/") + 1);
            Storage::disk($file->disk)->delete(SELF::THUMB.$original_filename);

        });
    }

    /**
     * Get the user that uploaded the file.
     *
     * @return void
     */
    public function uploader()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the file's path.
     *
     * @param string $path
     * @return string|null
     */
    public function getPathAttribute($path)
    {
        if (! is_null($path)) {
            return Storage::disk($this->disk)->url($path);
        }
    }

    public function getThumbAttribute($thumb)
    {
        if (!empty($thumb)) {
            return Storage::disk($this->disk)->url($thumb);
        }
        else {
            return $this->path;
        }
    }

    /**
     * Determine if the file type is image.
     *
     * @return bool
     */
    public function isImage()
    {
        return strtok($this->mime, '/') === 'image';
    }

    /**
     * Get the file's icon.
     *
     * @return string
     */
    public function icon()
    {
        return IconResolver::resolve($this->mime);
    }

    /**
     * Get table data for the resource
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function table($request)
    {
        $query = $this->newQuery()
            ->when(! is_null($request->type) && $request->type !== 'null', function ($query) use ($request) {
                $query->where('mime', 'LIKE', "{$request->type}/%");
            });

        return new MediaTable($query);
    }
}
