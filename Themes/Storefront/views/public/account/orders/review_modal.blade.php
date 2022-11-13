<div class="modal fade" id="post-review" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    <i class="fa fa-times" aria-hidden="true"></i>
                </button>

                <h4 class="modal-title">{{ 'Reviews' }}</h4>
            </div>

            <div class="review-form">

                <div class="modal-body">

                    <div class="user-review clearfix">
                        <div class="comment" v-for='review in reviewed'>
                            <div class="comment-details">
                                <img :src="review.image" height="100px" />
                                <h5 class="user-name">@{{ review.name }} </h5>
                                <fieldset class="rating">
                                    <span class="product-rating" v-html='buildRating(review.rating)'>
                                    </span>
                                </fieldset>
                                <p class="user-text">@{{ review.comment }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="modal-body">
                        <div class="user-review clearfix" v-for='(review, index) in unreviewed' v-bind:key='index'>
                            <p>@{{ review.name }} <span></p>
                            <img :src="review.image" height="100px" />
                            <p><a href="#" @click='setReview(review.product_id)'>Review this product</a> </p>
                            <div v-if="current_product_id==review.product_id">
                                <span>
                                    {{ trans('storefront::product.reviews.your_rating') }}
                                    <span class="rating-required">*</span>
                                </span>

                                <div class="clearfix"></div>

                                <fieldset class="rating">
                                    <input type="radio" id="star-5" name="rating" value="5" v-model='current_rating'>
                                    <label class="full" for="star-5" data-toggle="tooltip"
                                        title="{{ trans('storefront::product.reviews.5_star') }}"></label>

                                    <input type="radio" id="star-4" name="rating" value="4" v-model='current_rating'>
                                    <label class="full" for="star-4" data-toggle="tooltip"
                                        title="{{ trans('storefront::product.reviews.4_star') }}"></label>

                                    <input type="radio" id="star-3" name="rating" value="3" v-model='current_rating'>
                                    <label class="full" for="star-3" data-toggle="tooltip"
                                        title="{{ trans('storefront::product.reviews.3_star') }}"></label>

                                    <input type="radio" id="star-2" name="rating" value="2" v-model='current_rating'>
                                    <label class="full" for="star-2" data-toggle="tooltip"
                                        title="{{ trans('storefront::product.reviews.2_star') }}"></label>

                                    <input type="radio" id="star-1" name="rating" value="1" v-model='current_rating'>
                                    <label class="full" for="star-1" data-toggle="tooltip"
                                        title="{{ trans('storefront::product.reviews.1_star') }}"></label>
                                </fieldset>
                                <span class="error-message" v-if="hasError('rating')">Rating is required</span>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group }}">
                                            <label for="comment">
                                                {{ trans('storefront::product.reviews.your_review') }}<span>*</span>
                                            </label>
                                            <textarea v-model="current_comment" name="comment" class="form-control"
                                                cols="20" rows="3"></textarea>
                                            <span class="error-message" v-if="hasError('comment')">Comment is required</span>
                                        </div>
                                    </div>
                                    <button id ='add-review-button' class="btn btn-primary review-submit" data-loading @click='createReview()'>
                                        {{ trans('storefront::product.reviews.add_review') }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
