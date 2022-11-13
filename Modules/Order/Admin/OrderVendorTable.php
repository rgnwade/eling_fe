<?php

namespace Modules\Order\Admin;

use Modules\Admin\Ui\AdminTable;
use Modules\Order\Entities\Order;

class OrderVendorTable extends AdminTable
{
    /**
     * Make table response for the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function make()
    {
        return $this->newTable()
            ->addColumn('customer_name', function ($order) {
                return $order->customer_first_name.' '.$order->customer_last_name;
            })
            ->editColumn('total_vendor', function ($order) {
                return $order->formatted_total_vendor;
            })
            ->editColumn('status', function ($order) {
                return $order->status;
            });
    }
}
