<div class="single-image-wrapper">
    <h4>{{ $title }}</h4>

    <button type="button" class="image-picker btn btn-default" data-input-name="{{ $inputName }}">
        <i class="fa fa-folder-open m-r-5"></i>{{ trans('media::media.browse') }}
    </button>

    <div class="clearfix"></div>

    <div class="single-image image-holder-wrapper clearfix">
        <div class="image-holder placeholder">
            <i class="fa fa-picture-o"></i>
        </div>
    </div>
</div>
