<?php

namespace Modules\Product\Admin;

use Modules\Admin\Ui\VendorTable;

class ProductVendorTable extends VendorTable
{
    /**
     * Raw columns that will not be escaped.
     *
     * @var array
     */
    protected $rawColumns = [];

    /**
     * Make table response for the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function make()
    {
        return $this->newTable()
            ->editColumn('thumbnail', function ($product) {
                $path = optional($product->base_image)->thumb;

                return view('product::admin.products.partials.table.thumbnail', compact('path'));
            })
            ->editColumn('created', function ($entity) {
                return view('admin::partials.table.date')->with('date', $entity->created_at);
            })
            ->editColumn('vendor_price', function ($product) {
                    return $product->vendor_price->format($product->vendor_currency);

            });
    }
}
