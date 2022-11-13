<?php

namespace Modules\Product\Http\Controllers\Vendor;

use Illuminate\Routing\Controller;
use Modules\Product\Entities\Product;
use Modules\Admin\Traits\HasCrudActions;
use Modules\Product\Http\Requests\SaveProductVendorRequest;
use Modules\Product\Events\ProductViewed;
use Modules\Core\Http\Traits\LogTrait;
use Modules\Category\Entities\Category;
use Modules\Product\Entities\ProductVideotron;
use Modules\Attribute\Entities\Attribute;
use Modules\Attribute\Entities\AttributeSet;
use Illuminate\Http\Request;
use Modules\Product\Entities\StockProductStatus;
use Illuminate\Support\Facades\DB;

class ProductVideotronController extends ProductController
{

    use HasCrudActions;

    // use LogTrait;

    /**
     * Model for the resource.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Label of the resource.
     *
     * @var string
     */
    protected $label = 'product::products.product';

    /**
     * View path of the resource.
     *
     * @var string
     */
    protected $viewPath = 'product::vendor.products';

    /**
     * Form requests for the resource.
     *
     * @var array|string
     */
    protected $validation = SaveProductVendorRequest::class;

    public function createVideotron()
    {
        $data = array_merge([
            $this->getResourceName() => $this->getModel(),
            'categories' => Category::treeList(),
            'stock_status' => StockProductStatus::list(),
            'attributeSets' => $this->getAttributeSets(),
        ], $this->getFormData('create'));


        return view("{$this->viewPath}.create_videotron", $data);
    }

    public function storeVideotron()
    {
        $this->disableSearchSyncing();
        $default = collect([
            'price' => PRODUCT::DEFAULT_PRICE,
            'manage_stock' => PRODUCT::DEFAULT_MANAGE_STOCK,
            'in_stock' => PRODUCT::DEFAULT_IN_STOCK,
            'is_active' => PRODUCT::DEFAULT_IS_ACTIVE,
            'company_id' => auth()->user()->company_id,
            'unit' =>  PRODUCT::M2,
            'vendor_product_status_id' => PRODUCT::DEFAULT_VENDOR_PRODUCT_STATUS,
        ]);

        DB::beginTransaction();
        try {

            $entity = $this->model::create(
                $default->merge($this->getRequest('store'))->all()
            );

            $videotron = new ProductVideotron;
            $videotron->product_id  =  $entity->id;
            $videotron->cabinet_length =  request()->cabinet_length;
            $videotron->cabinet_width  =  request()->cabinet_width;
            $videotron->cabinet_depth  =  request()->cabinet_depth;
            $videotron->save();
            $entity->categories()->sync(PRODUCT::VIDEOTRON_CATEGORY);
            $this->createLog($entity, 'create', $this->getRequest('store'));
            $this->searchable($entity);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
        }
        if (method_exists($this, 'redirectTo')) {
            return $this->redirectTo($entity);
        }

        return redirect()->back()
            ->withSuccess(trans('admin::messages.resource_saved', ['resource' => $this->getLabel()]));
    }


    public function update($id)
    {
        $entity = $this->getEntity($id);

        $this->disableSearchSyncing();

        $default = [
            'is_active' => PRODUCT::DEFAULT_IS_ACTIVE,
            'vendor_product_status_id' => PRODUCT::DEFAULT_VENDOR_PRODUCT_STATUS
        ];

        DB::beginTransaction();
        try {

            $entity->update(
                $this->getRequest('update')->merge($default)->all()
            );
            ProductVideotron::where('product_id',  $entity->id)
                ->update([
                    'cabinet_length' => request()->cabinet_length,
                    'cabinet_width' =>  request()->cabinet_width,
                    'cabinet_depth' =>  request()->cabinet_depth
                ]);
            $this->createLog($entity, 'edit', $this->getRequest('update'));
            $this->searchable($entity);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
        }

        if (method_exists($this, 'redirectTo')) {
            return $this->redirectTo($entity)
                ->withSuccess(trans('admin::messages.resource_saved', ['resource' => $this->getLabel()]));
        }

        return redirect()->back()
            ->withSuccess(trans('admin::messages.resource_saved', ['resource' => $this->getLabel()]));
    }
}
