<div class="thumbnail-holder">
    @if ($file->isImage())
        <img src="{{ $file->thumb }}">
    @else
        <i class="file-icon fa {{ $file->icon() }}"></i>
    @endif
</div>
