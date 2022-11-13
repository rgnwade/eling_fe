<?php

namespace Modules\Media\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class MediaResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'path' => $this->path,
            'thumb' => $this->thumb,
            'filename' => $this->filename,
            'extension' => $this->extension
        ];
    }
}
