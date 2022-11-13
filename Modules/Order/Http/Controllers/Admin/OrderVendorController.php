<?php

namespace Modules\Order\Http\Controllers\Admin;

use Modules\Order\Entities\Order;
use Modules\Order\Entities\OrderPaymentCompany;
use Illuminate\Routing\Controller;
use Modules\Admin\Traits\HasCrudActions;
use Modules\Order\Http\Requests\StoreOrderRequest;
use Modules\Support\Money;
use Modules\Company\Entities\Company;
use Modules\Order\Entities\CompanyOrder;

class OrderVendorController extends Controller
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
    protected $viewPath = 'order::admin.orders_vendor';

    /**
     * Form requests for the resource.
     *
     * @var array
     */
    protected $validation = StoreOrderRequest::class;


    public function show($order_id, $vendor_id)
    {
        $order_id = $order_id . '-' . $vendor_id;
        $order = Order::find($order_id);
        $order_products =  $order->products->where('product.company_id', $vendor_id);
        $currency = $order_products->first()->product->vendor_currency;
        $total_order = Money::inVendorCurrency($order_products->sum('line_total_vendor'), $currency);

        $vendor = Company::find($vendor_id);

        $payments =  $order->filterPaymentByCompany($vendor_id);
        $company_order = CompanyOrder::where('order_id', $order_id)->where('company_id', $vendor_id)->first();

        return view("{$this->viewPath}.show")
            ->with('order', $order)
            ->with('order_products', $order_products)
            ->with('order_id',  $order_id)
            ->with('total_order',  $total_order)
            ->with('payments',  $payments)
            ->with('company_order',  $company_order)
            ->with('vendor',  $vendor);
    }
}
