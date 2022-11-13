<div class="form-group">
    <label for="{{ $inputName }}" class="control-label text-left">{{ $title }}</label>
    <div class="">
        <button type="button" class="file-picker btn btn-default" data-input-name="{{ $inputName }}">
            <i class="fa fa-folder-open m-r-5"></i>{{ trans('media::media.browse') }}
        </button>
        <div class="single-image file-holder-wrapper" style="padding:5px">
            @if (!$file->exists)
            <div class="file-holder">
               {{ trans('media::media.no_file') }}
            </div>
            @else
            <div class="file-holder">
                <a href="{{ $file->path }}" target="_blank"> {{ $file->filename }} </a>
                    <button type="button" class="btn remove-file" data-input-name="{{ $inputName }}"></button>
                    <input type="hidden" name="{{ $inputName }}" value="{{ $file->id }}">
            </div>
            @endif
        </div>
    </div>
</div>
