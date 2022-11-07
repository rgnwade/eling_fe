<?php

namespace Modules\Product\Http\Controllers\Admin;

use Illuminate\Routing\Controller;
use Modules\Product\Entities\Product;
use Modules\Admin\Traits\HasCrudActions;
use Modules\Product\Http\Requests\SaveProductRequest;
use Modules\Product\Events\ProductViewed;
use Modules\Core\Http\Traits\LogTrait;

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
    protected $viewPath = 'product::admin.products';

    /**
     * Form requests for the resource.
     *
     * @var array|string
     */
    protected $validation = SaveProductRequest::class;


    public function store()
    {
        $this->disableSearchSyncing();

        $entity = $this->model::create(
            $this->getRequest('store')->all()
        );

        $this->createLog($entity, 'create', $this->getRequest('store'));

        $this->searchable($entity);

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

        $entity->update(
            $this->getRequest('update')->all()
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
        if (! setting('reviews_enabled')) {
            return collect();
        }

        return $product->reviews()->paginate(15, ['*'], 'reviews');
    }

}
