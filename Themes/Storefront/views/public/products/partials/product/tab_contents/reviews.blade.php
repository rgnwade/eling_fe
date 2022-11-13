<div id="reviews" class="reviews tab-pane fade in clearfix {{ request()->has('reviews') || review_form_has_error($errors) ? 'active' : '' }}">
    <div class="row">
        @include('public.products.partials.product.reviews.ratings_overview')

        <div class="col-lg-8 col-md-7">
            <div class="user-review clearfix">
                @forelse ($reviews as $review)
                    <div class="comment">
                        <div class="comment-details">
                            <h5 class="user-name">{{ $review->reviewer_name }}</h5>

                            <span class="time" data-toggle="tooltip" title="{{ $review->created_at->toFormattedDateString() }}">
                                {{ $review->created_at->diffForHumans() }}
                            </span>

                            @include('public.products.partials.product.rating', ['rating' => $review->rating])

                            <p class="user-text">{{ $review->comment }}</p>
                        </div>
                    </div>
                @empty
                    <h3>{{ trans('storefront::product.reviews.there_are_no_reviews_for_this_product') }}</h3>
                @endforelse

                <div class="pull-right">
                    {!! $reviews->links() !!}
                </div>
            </div>
        </div>
    </div>
</div>
