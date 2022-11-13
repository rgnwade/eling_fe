<?php

namespace Modules\Review\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;
use Modules\Order\Entities\Order;
use Modules\Product\Entities\Product;
use Modules\Review\Entities\Review;
use Modules\Review\Http\Requests\StoreReviewRequest;

class ProductReviewController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param int $productId
     * @param \Modules\Review\Http\Requests\StoreReviewRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store($productId, StoreReviewRequest $request)
    {
        if (!setting('reviews_enabled')) {
            return back();
        }

        Product::findOrFail($productId)
            ->reviews()
            ->create([
                'reviewer_id' => auth()->id(),
                'rating' => $request->rating,
                'reviewer_name' => $request->reviewer_name,
                'comment' => $request->comment,
                'is_approved' => setting('auto_approve_reviews', 0),
            ]);

        return back()->withSuccess($this->message());
    }

    /**
     * Returns the success message.
     *
     * @return string
     */
    private function message()
    {
        if (setting('auto_approve_reviews')) {
            return trans('review::messages.thank_you');
        }

        return trans('review::messages.submitted_for_approval');
    }

    public function save()
    {
        $user = auth()->user();
        $order = Order::find(request('order_id'));
        if ($user->id != $order->customer_id) {
            return json_encode(["success" => false]);
        }
        $data = [
            'order_id' => request('order_id'),
            'product_id' => request('product_id'),
            'comment' => request('comment'),
            'rating' => request('rating'),
            'reviewer_name' => $user->fullname,
            'reviewer_id' => $user->id,
            'is_approved' => setting('auto_approve_reviews', 0)
        ];
        Review::create($data);

        $average = Review::where('product_id', request('product_id'))
            ->avg('rating');
        $average = round($average, 2);
        Product::where('id', request('product_id'))
            ->update(['rating' => $average]);
        return json_encode(["success" => true, "average" => $average]);
    }
}
