<?php

namespace Modules\Order\Http\Controllers\Admin;

use Modules\Order\Entities\Order;
use Illuminate\Routing\Controller;
use Modules\Media\Entities\File;
class OrderPrintController extends Controller
{
    /**
     * Show the specified resource.
     *
     * @param \Modules\Order\Entities\Order $order
     * @return \Illuminate\Http\Response
     */
    // public function show(Order $order)
    // {
    //     $order->load('products', 'coupon', 'taxes');

    //     return view('order::admin.orders.print.show', compact('order'));
    // }

    public function show($id)
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
}
