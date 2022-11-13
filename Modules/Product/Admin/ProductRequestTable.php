<?php

namespace Modules\Product\Admin;

use Modules\Admin\Ui\AdminTable;

class ProductRequestTable extends AdminTable
{
    /**
     * Raw columns that will not be escaped.
     *
     * @var array
     */
    protected $rawColumns = ['price','preview'];

    /**
     * Make table response for the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function make()
    {
        return $this->newTable()
            ->addColumn('preview', function ($product) {
                $previewUrl = route('admin.products.preview', $product->id);
                return "<a href='{$previewUrl}'  target='_blank'>".trans('product::products.table.preview')."</a>";
            })
            ->editColumn('thumbnail', function ($product) {
                $path = optional($product->base_image)->thumb;

                return view('product::admin.products.partials.table.thumbnail', compact('path'));
            })
            ->editColumn('vendor_price', function ($product) {
                    return $product->vendor_price->format($product->vendor_currency);
            })
            ->editColumn('price', function ($product) {
                if (! $product->hasSpecialPrice()) {
                    return $product->price->format();
                }

                return "<span class='m-r-5'>{$product->special_price->format()}</span>
                    <del class='text-red'>{$product->price->format()}</del>";
            });
    }

     public function newTable()
    {
        return datatables($this->source)
            ->addColumn('checkbox', function ($entity) {
                return view('admin::partials.table.checkbox', compact('entity'));
            })
            ->editColumn('status', function ($entity) {
                $is_active =  $entity->is_active
                    ? '<span class="dot green"></span>'
                    : '<span class="dot red"></span>';
                    return $entity->vendorProductStatus->name.' '.$is_active;
            })
            ->editColumn('created', function ($entity) {
                return view('admin::partials.table.date')->with('date', $entity->created_at);
            })
            ->editColumn('updated', function ($entity) {
                return view('admin::partials.table.date')->with('date', $entity->updated_at);
            })
            ->rawColumns(array_merge($this->defaultRawColumns, $this->rawColumns))
            ->removeColumn('translations');
    }
}


