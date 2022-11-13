<?php

namespace Modules\Account\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Order\Entities\Order;
use Modules\Order\Entities\CompanyOrder;
use Modules\Media\Entities\File;

class AccountOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = auth()->user()
            ->orders()
            ->latest()
            ->paginate(15);

        return view('public.account.orders.index', compact('orders'));
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $order = auth()->user()
            ->orders()
            ->with(['products', 'coupon', 'taxes'])
            ->where('id', $id)
            ->firstOrFail();

        return view('public.account.orders.show', compact('order'));
    }

    public function invoice($id)
    {

        $logo = File::findOrNew(setting('storefront_mail_logo'))->path;

        if (auth()->user()->isAdmin()) {
            $order = Order::with(['products', 'coupon', 'taxes'])
                ->where('id', $id)
                ->firstOrFail();
        } else {
            $order = auth()->user()
                ->orders()
                ->with(['products', 'coupon', 'taxes'])
                ->where('id', $id)
                ->firstOrFail();
        }
        $companyOrders =  $order->productsGroupByCompany();
        return view('public.invoice', compact('order', 'logo', 'companyOrders'));
    }

    public function review($id)
    {
        $order = Order::findOrFail($id);
        $products = [];
        $reviews = [];
        $unreviewed = [];
        $review_list = [];

        foreach ($order->reviews as $review) {
            $reviews[] = $review;
        }

        foreach ($order->products as $product) {
            $products[] = $product;
            $reviewed = null;
            foreach ($reviews as $review) {
                if ($product->product_id == $review->product_id) {
                    $reviewed = $review;
                    break;
                }
            }

            if ($reviewed == null) {
                $unreviewed[] = $this->buildProduct($product);
            } else {
                $review_list[] = $this->buildReview($product, $reviewed);
            }
        }

        return [
            "reviewed" => $review_list,
            "unreviewed" => $unreviewed
        ];
    }

    public function completed($id)
    {
        $order = Order::findOrFail($id);
        if ($order->customer_id != Auth::user()->id) {
            return redirect()->route('account.orders.show', $id)
                ->withError(trans('order::messages.update_error'));
        }
        $order->update(['status' => Order::RECEIVED]);
        return redirect()->route('account.orders.show', $id)
            ->withSuccess(trans('storefront::account.view_order.complete_notification'));
    }

    private function buildReview($product, $review)
    {
        $reviews = $this->buildProduct($product);
        $reviews['rating'] = $review->rating;
        $reviews['comment'] = $review->comment;
        return $reviews;
    }

    private function buildProduct($product)
    {
        return [
            "product_id" => $product->product_id,
            "name" => $product->getNameAttribute(),
            "image" => $product->product->baseImage->thumb,
            "qty" => $product->qty,
            "rating" => '',
            "comment" => ''
        ];
    }
}
