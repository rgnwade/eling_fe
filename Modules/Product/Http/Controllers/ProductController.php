<?php

namespace Modules\Product\Http\Controllers;

use Illuminate\Routing\Controller;
use Modules\Product\Entities\Product;
use Modules\Category\Entities\Category;
use Modules\Product\Events\ProductViewed;
use Modules\Product\Filters\ProductFilter;
use Modules\Product\Events\ShowingProductList;
use Modules\Product\Http\Middleware\SetProductSortOption;
use Illuminate\Support\Facades\Auth;
use Modules\Support\Chat;

class ProductController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(SetProductSortOption::class)->only('index');
    }

    /**
     * Display a listing of the resource.
     *
     * @param \Modules\Product\Entities\Product $model
     * @param \Modules\Product\Filters\ProductFilter $productFilter
     * @return \Illuminate\Http\Response
     */
    public function index(Product $model, ProductFilter $productFilter)
    {
        $productIds = [];

        if(request('category')){
             $category = Category::findBySlug(request('category'))->name;
        }else{
            $category = '';
        }
        
        if (request()->has('query')) {
            $model = $model->search(request('query'));
            $productIds = $model->keys();
        }

        $query = $model->filter($productFilter);

        if (request()->has('category')) {
            $productIds = (clone $query)->select('products.id')->resetOrders()->pluck('id');
        }

        $products = $query->paginate(request('perPage', 15))
            ->appends(request()->query());

        if (request()->wantsJson()) {
            return response()->json($products);
        }

        event(new ShowingProductList($products));

        return view('public.products.index', compact('products', 'productIds','category'));
    }

    /**
     * Show the specified resource.
     *
     * @param string $slug
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $product = Product::findBySlug($slug);
        $relatedProducts = $product->relatedProducts()->forCard()->get();
        $upSellProducts = $product->upSellProducts()->forCard()->get();
        $reviews = $this->getReviews($product);
        $user = Auth::user();
        $chat = array();
        if ($user != null) {
            $chat = Chat::properties($user, $product->company);
        }

        if (setting('reviews_enabled')) {
            $product->load('reviews:product_id,rating');
        }

        $context = [
            'productName' => $product->name,
            'productId' => (string) $product->id,
            'imageLink' => $product->baseImage->path,
            'price' => product_price($product),
            'productLink' => route('products.show', ['slug' => $product->slug])
        ];

        event(new ProductViewed($product));

        return view('public.products.show', compact('product', 'relatedProducts', 'upSellProducts', 'reviews', 'chat', 'context'));
    }

    /**
     * Get reviews for the given product.
     *
     * @param \Modules\Product\Entities\Product $product
     * @return \Illuminate\Support\Collection
     */
    private function getReviews($product)
    {
        if (!setting('reviews_enabled')) {
            return collect();
        }

        return $product->reviews()->paginate(15, ['*'], 'reviews');
    }
}
