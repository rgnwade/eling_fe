<?php

namespace Modules\Order\Http\Controllers\Admin;

use Modules\Order\Entities\Order;
use Modules\Order\Entities\OrderPayment;
use Illuminate\Routing\Controller;
use Modules\Admin\Traits\HasCrudActions;
use Modules\Order\Http\Requests\StoreOrderRequest;

class OrderController extends Controller
{
    use HasCrudActions;

    /**
     * Model for the resource.
     *
     * @var string
     */
    protected $model = Order::class;

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = ['products', 'coupon', 'taxes'];

    /**
     * Label of the resource.
     *
     * @var string
     */
    protected $label = 'order::orders.order';

    /**
     * View path of the resource.
     *
     * @var string
     */
    protected $viewPath = 'order::admin.orders';

    /**
     * Form requests for the resource.
     *
     * @var array
     */
    protected $validation = StoreOrderRequest::class;


    public function show($id)
    {
        $order = Order::find($id);
        $order_products_company =  $order->productsGroupByCompany();

        if (request()->wantsJson()) {
            return $order;
        }

        return view("{$this->viewPath}.show")
            ->with($this->getResourceName(), $order)
            ->with('payment_statuses',  OrderPayment::STATUSES)
            ->with('order_products_company', $order_products_company);
    }
}
