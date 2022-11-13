<div class="form-group">
    <label for="{{ $inputName }}" class="col-md-3 control-label text-left">{{ $title }}</label>
    <div class="col-lg-4" style="display: inline-grid;">
        <button type="button" class="image-picker btn btn-default" data-input-name="{{ $inputName }}">
            <i class="fa fa-folder-open m-r-5"></i>{{ trans('media::media.browse') }}
        </button>
        <div class="single-image image-holder-wrapper">
            @if (! $file->exists)
            <div class="image-holder placeholder">
                <i class="fa fa-picture-o"></i>
            </div>
            @else
            <div class="image-holder">
                <img src="{{ $file->path }}">
                <button type="button" class="btn remove-image" data-input-name="{{ $inputName }}"></button>
                <input type="hidden" name="{{ $inputName }}" value="{{ $file->id }}">
            </div>
            @endif
        </div>
    </div>
</div>
