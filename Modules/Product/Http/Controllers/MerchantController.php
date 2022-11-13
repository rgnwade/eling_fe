<?php

namespace Modules\Product\Http\Controllers;

use Illuminate\Routing\Controller;
use Modules\Product\Entities\Product;
use Modules\Company\Entities\Company;
use Modules\Product\Events\ProductViewed;
use Modules\Product\Filters\ProductFilter;
use Modules\Product\Events\ShowingProductList;
use Modules\Product\Http\Middleware\SetProductSortOption;
use Illuminate\Support\Facades\Auth;
use Modules\Support\Chat;

class MerchantController extends Controller


{
    const SOCIALS = ['instagram', 'twitter', 'facebook', 'website'];
    const PROFILE = 'profile';
    /**
     *
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
        $company = Company::findBySlug(request()->slug);
        $profile = $company->getInfo(SELF::PROFILE);
        $socials = array();
        foreach (SELF::SOCIALS as $info) {
            $socials[] = $company->getInfo($info);
        }

        $user = Auth::user();
        $chat = array();
        if ($user != null) {
            $chat = Chat::properties($user, $company);
        }

        $rating =$company->avgRating();
        $productIds = [];

        if (request()->has('query')) {
            $model = $model->search(request('query'));
            $productIds = $model->keys();
        }

        $query = $model->filter($productFilter);

        $products = $query->where('company_id', $company->id)
            ->paginate(request('perPage', 15))
            ->appends(request()->query());

        if (request()->wantsJson()) {
            return response()->json($products);
        }



        event(new ShowingProductList($products));

        return view('public.products.merchant', compact('products', 'productIds','company', 'profile', 'socials', 'chat', 'rating'));
    }
}
