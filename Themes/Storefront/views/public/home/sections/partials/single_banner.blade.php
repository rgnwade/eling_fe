<a href="{{ $banner->call_to_action_url }}" class="banner {{ $class ?? '' }}" style="background-image: url({{ $banner->image->path }});" target="{{ $banner->open_in_new_window ? '_blank' : '_self' }}">
    <div class="overlay"></div>

    <div class="display-table">
        <div class="display-table-cell">
            <div class="banner-content">
                <h3>{{ $banner->caption_1 }}</h3>
                <p>{{ $banner->caption_2 }}</p>
                <span>
                    {{ $banner->call_to_action_text }}
                    @if(!empty($banner->call_to_action_text))
                        <i class="fa fa-long-arrow-right" aria-hidden="true"></i>
                    @endif
                </span>
            </div>
        </div>
    </div>
</a>
