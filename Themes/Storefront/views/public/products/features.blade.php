<section class="wrapper clearfix">
    <div class="row">
        <div class="col-lg-12 col-sm-12">
            <div class="row">
                <div class="col-lg-3 col-sm-3">
                    <div class="merchant-logo-wrapper">
                        @if ($company->baseImage->path)
                            <img src=" {{ $company->baseImage->path }}" class="merchant-logo">
                        @endif
                            <div class="row">
                                <h5>{{ $company->name }}</h5>
                            </div>
                            <span class="rating">
                                <i class="{{ rating_star_class($rating, 1) }}"></i>
                                <i class="{{ rating_star_class($rating, 2) }}"></i>
                                <i class="{{ rating_star_class($rating, 3) }}"></i>
                                <i class="{{ rating_star_class($rating, 4) }}"></i>
                                <i class="{{ rating_star_class($rating, 5) }}"></i>
                            </span>

                        @auth
                            @if ($chat['user']['is_seller'] == false)
                                <div class="row">
                                    <div class="add-to clearfix">
                                        <button type="submit" id="chat-button" class="btn btn-primary" onclick="loadGroupChat(
                                                '{{$chat['client_group_id']}}',
                                                '{{$chat['group_name']}}',
                                                {{json_encode($chat['company'])}},
                                                {{json_encode($chat['user'])}},
                                                {{json_encode($chat['icon'])}},
                                                )" data-loading>{{ trans('storefront::product.chat_with_seller') }} <i
                                                class="fa fa-comment "></i> </button>
                                    </div>
                                </div>
                            @endif
                        @endauth
                    </div>
                    <div class="merchant-social">

                        @if ($company->email != null || $company->email != '')
                        <div class="row">
                            <i class="fa fa-envelope fa-fw" aria-hidden="true"></i>
                            <span class="contact-info">{{ $company->email }} </span>
                        </div>
                        @endif

                        @if ($company->phone != null || $company->phone != '')
                        <div class="row">
                            <i class="fa fa-phone fa-fw" aria-hidden="true"></i>
                            <span class="contact-info">{{ $company->phone }} </span>
                        </div>
                        @endif

                        @if ($company->country != null)
                        <div class="row">
                            <i class="fa fa-map-marker fa-fw" aria-hidden="true"></i>
                            <span class="contact-info">{{ $company->country->name }} </span>
                        </div>
                        @endif

                        @foreach ($socials as $social)
                        <div class="row">
                            @if ($social->value)
                                @if ($social->title == 'website')
                                <i class="fa fa-globe fa-fw" aria-hidden="true"></i>
                                @else
                                <i class="fa fa-{{ $social->title }} fa-fw" aria-hidden="true"></i>
                                @endif
                            <span class="contact-info">{{ $social->value }}</span>
                            @endif
                        </div>
                        @endforeach
                    </div>


                </div>
                <div class="col-lg-9 col-sm-9">
                    <div class="row">
                        <div class="col-lg-12 col-sm-12">
                            <div class="row">
                                @if ($company->additionalImages->isNotEmpty())
                                <div class="merchant-gallery">
                                    <div class="home-slider" data-autoplay="true" data-autoplay-speed="3000"
                                        data-arrows="true">
                                        @foreach ($company->additionalImages as $slide)
                                        <div class="slide">
                                            <div class="slider-image"
                                                style="background-image: url({{ $slide->path }});"></div>
                                            <div class="display-table">
                                                <div class="display-table-cell">
                                                    <div class="col-md-9 col-md-offset-1 col-sm-10 col-sm-offset-1">
                                                        <div class="slider-content clearfix"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                                @else
                                <div class="merchant-info-body">
                                    {!! $profile->value !!}
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @if ($company->additionalImages->isNotEmpty())
            <div class="row">
                <div class="col-lg-12 col-sm-12">
                    <div class="merchant-info-body">
                        {!! $profile->value !!}
                    </div>
                </div>
            </div>
        @endif
</section>
<br>
