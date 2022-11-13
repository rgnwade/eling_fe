<?php

namespace Modules\Media\Http\Controllers\Vendor;

use Illuminate\Http\Request;

class FileManagerController
{
    /**
     * Display a listing of the resource..
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $type = request('type');

        return view('media::vendor.file_manager.index', compact('type'));
    }
}
