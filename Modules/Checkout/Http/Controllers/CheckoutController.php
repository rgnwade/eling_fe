<?php

namespace Modules\Checkout\Http\Controllers;

use Exception;
use Modules\Support\Country;
use Modules\Cart\Facades\Cart;
use Modules\Page\Entities\Page;
use Illuminate\Routing\Controller;
use Modules\Payment\Facades\Gateway;
use Modules\Checkout\Events\OrderPlaced;
use Modules\User\Services\CustomerService;
use Modules\Checkout\Services\OrderService;
use Modules\Order\Entities\Order;
use Modules\Order\Http\Requests\StoreOrderRequest;
use Illuminate\Support\Facades\DB;
class CheckoutController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['cart_not_empty', 'check_stock', 'check_coupon_usage_limit']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(!auth()->user()->completedRegisterCustomer()){
            return redirect()->route('account.dashboard.index');
        }

        $cart = Cart::instance();
        $countries = Country::supported();
        $gateways = Gateway::all();
        $termsPageURL = Page::urlForPage(setting('storefront_terms_page'));
        $last_order = auth()->user()->orders()->orderby('id', 'desc')->first();

        return view('public.checkout.create', compact('cart', 'countries', 'gateways', 'termsPageURL', 'last_order'));
    }

    

    /**
     * Store a newly created resource in storage.
     *
     * @param \Modules\Order\Http\Requests\StoreOrderRequest $request
     * @param \Modules\User\Services\CustomerService $customerService
     * @param \Modules\Checkout\Services\OrderService $orderService
     * @return \Illuminate\Http\Response
     */
    public function store(StoreOrderRequest $request, CustomerService $customerService, OrderService $orderService)
    {
        if (auth()->guest() && $request->create_an_account) {
            $customerService->register($request)->login();
        }
        
        DB::beginTransaction();
        try {
            $order = $orderService->create($request);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return back()->withInput()->withError($e->getMessage());
        }

        $gateway = Gateway::get($request->payment_method);

        try {
            $response = $gateway->purchase($order, $request);
        } catch (Exception $e) {
            $orderService->delete($order);

            return back()->withInput()->withError($e->getMessage());
        }

        if ($response->isRedirect()) {
            return redirect($response->getRedirectUrl());
        } elseif ($response->isSuccessful()) {
            $order->storeTransaction($response);

            event(new OrderPlaced($order));

            return redirect()->route('checkout.complete.show');
        }

        $orderService->delete($order);

        return back()->withInput()->withError($response->getMessage());
    }
}
