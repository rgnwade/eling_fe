<?php

namespace Modules\Media\Http\Controllers\Vendor;

use Illuminate\Http\Response;
use Modules\Media\Entities\File;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Storage;
use Modules\Admin\Traits\HasCrudActions;
use Modules\Media\Http\Requests\UploadMediaVendorRequest;
use Modules\Media\Http\Requests\UploadMediaRequest;
use Image;
use Illuminate\Http\Request;

class MediaController extends Controller
{
    use HasCrudActions;

    /**
     * Model for the resource.
     *
     * @var string
     */
    protected $model = File::class;

    /**
     * Label of the resource.
     *
     * @var string
     */
    protected $label = 'media::media.media';

    /**
     * View path of the resource.
     *
     * @var string
     */
    protected $viewPath = 'media::vendor.media';

    /**
     * Store a newly created media in storage.
     *
     * @param \Modules\Media\Http\Requests\UploadMediaRequest $request
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {

        $company_id = auth()->user()->company_id;
        if ($request->has('query')) {
            return $this->getModel()
                ->search($request->get('query'))
                ->query()
                ->where('company_id',$company_id)
                ->limit($request->get('limit', 10))
                ->get();
        }

        if ($request->has('table')) {
            return $this->getModel()->vendorTable($request, $company_id);

        }

        return view("{$this->viewPath}.index");
    }

    public function storeFile(UploadMediaRequest $request)
    {
        $file = $request->file('file');

        $path = Storage::putFile('media', $file);

        File::create([
            'user_id' => auth()->id(),
            'disk' => config('filesystems.default'),
            'filename' => $file->getClientOriginalName(),
            'path' => $path,
            'company_id' => auth()->user()->company_id,
            'extension' => $file->guessClientExtension() ?? '',
            'mime' => $file->getClientMimeType(),
            'size' => $file->getClientSize(),
        ]);

        return response('Created', Response::HTTP_CREATED);
    }

    public function store(UploadMediaVendorRequest $request)
    {
        $file = $request->file('file');

        $path = Storage::putFile('media', $file);
        $filename =$file->getClientOriginalName();
        $original_filename = substr($path, strpos($path, "/") + 1);

        Image::make('storage/'.$path)
        ->resize(300, null, function ($constraint) {
            $constraint->aspectRatio();
        })
        ->save('storage/media/'.File::THUMB.$original_filename);


        File::create([
            'user_id' => auth()->id(),
            'disk' => config('filesystems.default'),
            'filename' => $filename,
            'path' => $path,
            'thumb' => 'media/'.File::THUMB.$original_filename,
            'extension' => $file->guessClientExtension() ?? '',
            'mime' => $file->getClientMimeType(),
            'size' => $file->getClientSize(),
        ]);

        return response('Created', Response::HTTP_CREATED);
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param string $ids
     * @return \Illuminate\Http\Response
     */
    public function destroy($ids)
    {
        File::find(explode(',', $ids))->each->delete();
    }
}
