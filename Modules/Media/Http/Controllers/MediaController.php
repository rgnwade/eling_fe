<?php

namespace Modules\Media\Http\Controllers;

use Illuminate\Http\Response;
use Modules\Media\Entities\File;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Storage;
use Modules\Admin\Traits\HasCrudActions;
use Modules\Media\Http\Requests\UploadMediaRequest;
use Image;
use Modules\Company\Entities\Company;

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
    protected $viewPath = 'media::public.media';

    /**
     * Store a newly created media in storage.
     *
     * @param \Modules\Media\Http\Requests\UploadMediaRequest $request
     * @return \Illuminate\Http\Response
     */

    public function store(UploadMediaRequest $request)
    {
        $file = $request->file('file');
        $path = Storage::putFile('media', $file);
        $filename = $file->getClientOriginalName();
        $original_filename = substr($path, strpos($path, "/") + 1);

        Image::make('storage/' . $path)
            ->resize(300, null, function ($constraint) {
                $constraint->aspectRatio();
            })
            ->save('storage/media/' . File::THUMB . $original_filename);

        $file = File::create([
            'user_id' => auth()->id(),
            'disk' => config('filesystems.default'),
            'filename' => $filename,
            'path' => $path,
            'thumb' => 'media/' . File::THUMB . $original_filename,
            'extension' => $file->guessClientExtension() ?? '',
            'mime' => $file->getClientMimeType(),
            'size' => $file->getClientSize(),
            'company_id' => auth()->user()->company_id ?: 0
        ]);

        $this->syncFiles($request->get('name'), $file);
        return response(
            [
                'success' => true,
                'id' => $file->id,
                'path' => $file->path,
            ],
            Response::HTTP_CREATED
        );
    }


    public function storeFile(UploadMediaRequest $request)
    {
        $file = $request->file('file');

        $path = Storage::putFile('media', $file);
        $file = File::create([
            'user_id' => auth()->id(),
            'disk' => config('filesystems.default'),
            'filename' => $file->getClientOriginalName(),
            'path' => $path,
            'company_id' => auth()->user()->company_id ?: 0,
            'extension' => $file->guessClientExtension() ?? '',
            'mime' => $file->getClientMimeType(),
            'size' => $file->getClientSize(),
        ]);

        $this->syncFiles($request->get('name'), $file);
        return response(
            [
                'success' => true,
                'id' => $file->id,
                'path' => $file->path,
            ],
            Response::HTTP_CREATED
        );
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param string $ids
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        File::find($id)->delete();
    }

    private function syncFiles($name, $file)
    {
        if (auth()->user()->company_id) {
            Company::find(auth()->user()->company_id)->syncFiles(
                [$name => $file->id]
            );
        } else {
            auth()->user()->syncFiles(
                [$name => $file->id]
            );
        }
    }
}
