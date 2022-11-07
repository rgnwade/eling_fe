<?php

namespace Modules\Core\Admin;

use Modules\Admin\Ui\AdminTable;

class LogTable extends AdminTable
{
    /**
     * Raw columns that will not be escaped.
     *
     * @var array
     */
    // protected $rawColumns = ['user_name'];

    /**
     * Make table response for the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    // public function make()
    // {
    //     return $this->newTable()
    //         // ->addColumn('order_id', function ($transaction) {
    //         //     $orderUrl = route('admin.orders.show', $transaction->order_id);
    //         //     return "<a href='{$orderUrl}'>{$transaction->order_id}</a>";
    //         // })
    //         // ->editColumn('payment_total', function ($transaction) {
    //         //     return $transaction->payment_total->format('IDR');
    //         // }) ;
    // }
}
