<?php

namespace Modules\Product\Http\Controllers\Admin;

use Illuminate\Routing\Controller;
use Modules\Product\Entities\Product;
use Modules\Admin\Traits\HasCrudActions;
use Modules\Product\Http\Requests\SaveProductRequestVendor;
use Illuminate\Http\Request;
use Modules\Admin\Ui\Facades\TabManager;
use Modules\Currency\Entities\CurrencyRate;
use Modules\Product\Entities\ProductVideotron;
use Illuminate\Support\Facades\DB;
class ProductRequestController extends Controller
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
    protected $viewPath = 'product::admin.products';

    /**
     * Form requests for the resource.
     *
     * @var array|string
     */
    protected $validation = SaveProductRequestVendor::class;


    public function product(Request $request)
    {
        if ($request->has('query')) {
            return $this->getModel()
                ->search($request->get('query'))
                ->query()
                ->limit($request->get('limit', 10))
                ->get();
        }

        if ($request->has('table')) {
            return $this->getModel()->tableRequestVendor($request);
        }

        return view("{$this->viewPath}.index_vendor");
    }

    private function claculatePrice($formula, $vendor_price)
    {
        $rate = CurrencyRate::currentUSD();
        $result = 0;
        eval('$result = ' . $formula . ';');
        $result = round($result, -3);
        return $result;
    }

    public function update($id, Request $request)
    {
        $entity = $this->getEntity($id);

        $this->disableSearchSyncing();
        if($request->price_formula){
            $price = $this->claculatePrice($request->price_formula, $entity->vendor_price->amount());
        }
        $entity->update(
            $this->getRequest('update')->merge(['price' => $price])->all()
        );

        ProductVideotron::where('product_id',  $entity->id)
        ->update([
            'cabinet_length' => request()->cabinet_length,
            'cabinet_width' =>  request()->cabinet_width,
            'cabinet_depth' =>  request()->cabinet_depth
        ]);

        DB::table('products')
        ->where('id', $entity->id)
        ->update(['keyword' =>  $entity->keyword()]);

        $this->createLog($entity, 'edit product vendor', $this->getRequest('update'));

        $this->searchable($entity);

        if (method_exists($this, 'redirectTo')) {
            return $this->redirectTo($entity)
                ->withSuccess(trans('admin::messages.resource_saved', ['resource' => $this->getLabel()]));
        }

        return redirect()->back()
            ->withSuccess(trans('admin::messages.resource_saved', ['resource' => $this->getLabel()]));
    }

    public function edit($id)
    {
        $data = array_merge([
            'tabs' => TabManager::get('products_vendor'),
            $this->getResourceName() => $this->getEntity($id),
        ], $this->getFormData('edit', $id));

        return view("{$this->viewPath}.edit_vendor", $data);
    }
}
