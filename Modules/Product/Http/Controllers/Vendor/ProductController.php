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

class ProductController extends Controller
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

    public function index(Request $request)
    {
        if ($request->has('query')) {
            return $this->getModel()
                ->search($request->get('query'))
                ->query()
                ->where('company_id', auth()->user()->company_id)
                ->limit($request->get('limit', 10))
                ->get();
        }

        if ($request->has('table')) {
            return $this->getModel()->tableVendor($request);
        }

        return view("{$this->viewPath}.index");
    }


    public function store()
    {
        $this->disableSearchSyncing();

        //for_vendor_first_create
        $default = [
            'price' => PRODUCT::DEFAULT_PRICE,
            'manage_stock' => PRODUCT::DEFAULT_MANAGE_STOCK,
            'in_stock' => PRODUCT::DEFAULT_IN_STOCK,
            'is_active' => PRODUCT::DEFAULT_IS_ACTIVE,
            'company_id' => auth()->user()->company_id,
            'vendor_product_status_id' => PRODUCT::DEFAULT_VENDOR_PRODUCT_STATUS
        ];
        // dd( $this->getRequest('store')->merge($default)->all());
        $entity = $this->model::create(
            $this->getRequest('store')->merge($default)->all()
        );

        $this->createLog($entity, 'create', $this->getRequest('store'));

        $this->searchable($entity);

        if (method_exists($this, 'redirectTo')) {
            return $this->redirectTo($entity);
        }

        return redirect()->back()
            ->withSuccess(trans('admin::messages.resource_saved', ['resource' => $this->getLabel()]));
    }

    public function create()
    {
        $data = array_merge([
            $this->getResourceName() => $this->getModel(),
            'categories' => Category::treeList(),
            'stock_status' => StockProductStatus::list(),
            'attributeSets' => $this->getAttributeSets(),
        ], $this->getFormData('create'));


        return view("{$this->viewPath}.create", $data);
    }

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

    public function edit($id)
    {
        $product = $this->getEntity($id);
        if ($product->company_id != auth()->user()->company_id) {
            return back()->withError('Error');
        }
      

        $data = array_merge([
            $this->getResourceName() => $product,
            'categories' => Category::treeList(),
            'stock_status' => StockProductStatus::list(),
            'attributeSets' => $this->getAttributeSets(),
            'productAttributes' => $this->getProductAttributes($product),
        ], $this->getFormData('edit', $id));

        if($product->isVideotron()){
            return view("{$this->viewPath}.edit_videotron", $data);
        }
        return view("{$this->viewPath}.edit", $data);
    }


    public function update($id)
    {
        $entity = $this->getEntity($id);

        $this->disableSearchSyncing();

        $default = [
            'is_active' => PRODUCT::DEFAULT_IS_ACTIVE,
            'vendor_product_status_id' => PRODUCT::DEFAULT_VENDOR_PRODUCT_STATUS
        ];

        // dd( $this->getRequest('update')->all());

        $entity->update(
            $this->getRequest('update')->merge($default)->all()
        );

        $this->createLog($entity, 'edit', $this->getRequest('update'));

        $this->searchable($entity);

        if (method_exists($this, 'redirectTo')) {
            return $this->redirectTo($entity)
                ->withSuccess(trans('admin::messages.resource_saved', ['resource' => $this->getLabel()]));
        }

        return redirect()->back()
            ->withSuccess(trans('admin::messages.resource_saved', ['resource' => $this->getLabel()]));
    }


    public function preview($id)
    {
        $product = Product::getPreview($id);
        $relatedProducts = $product->relatedProducts()->forCard()->get();
        $upSellProducts = $product->upSellProducts()->forCard()->get();
        $reviews = $this->getReviews($product);

        if (setting('reviews_enabled')) {
            $product->load('reviews:product_id,rating');
        }

        event(new ProductViewed($product));

        return view('public.products.show', compact('product', 'relatedProducts', 'upSellProducts', 'reviews'));
    }

    private function getReviews($product)
    {
        if (!setting('reviews_enabled')) {
            return collect();
        }

        return $product->reviews()->paginate(15, ['*'], 'reviews');
    }


    private function getProductAttributes($product)
    {
        $old = old('attributes');

        if (is_null($old)) {
            return $product->load('attributes')->attributes;
        }

        return $this->getOldAttributes($old);
    }

    public function getOldAttributes($old)
    {
        return Attribute::with(['values' => function ($query) use ($old) {
            $query->whereIn('id', array_flatten(array_pluck($old, 'values')));
        }])
            ->whereIn('id', array_pluck($old, 'attribute_id'))
            ->get();
    }

    public function getAttributeSets()
    {
        return AttributeSet::with('attributes.values')->get()->sortBy('name');
    }
}
