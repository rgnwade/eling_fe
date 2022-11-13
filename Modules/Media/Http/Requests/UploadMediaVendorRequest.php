<?php

namespace Modules\Media\Http\Requests;

use Modules\Core\Http\Requests\Request;

class UploadMediaVendorRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'file' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:5048',
        ];
    }
}
