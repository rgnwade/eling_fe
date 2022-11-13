<?php

namespace Modules\Product\Http\Controllers;

use Illuminate\Routing\Controller;
use Modules\Product\Entities\Product;
use Modules\Product\Events\ShowingProductList;
use Carbon\Carbon;

class RecentProductController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
       
    }


    public function index()
    {
        
        $products = Product::whereDate('created_at', '>', Carbon::now()->subDays(30))->orderBy('created_at','desc')->paginate(15);
        
        if (request()->wantsJson()) {
            return response()->json($products);
        }

        event(new ShowingProductList($products));

        return view('public.recent_products.index', compact('products'));
    }

 
  
}
