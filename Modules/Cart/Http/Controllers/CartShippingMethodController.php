<?php

namespace Modules\Cart\Http\Controllers;

use Modules\Cart\Facades\Cart;
use Illuminate\Routing\Controller;
use Modules\Shipping\Facades\ShippingMethod;
use Illuminate\Http\Request;
use Config;
use Modules\Support\Money;
use Modules\Shipping\Method;
use Modules\Shipping\RajaOngkir;
use Illuminate\Support\Facades\Redis;

class CartShippingMethodController extends Controller
{
    protected $origin ; //penjaringan
    protected $raja_ongkir_url ;
    protected $raja_ongkir_key ;
    protected $weight_item_kg;


    function __construct() {
        $this->origin =  2127; //penjaringan
        $this->raja_ongkir_key = Config::get('app.RAJA_ONGKIR_KEY');
        $this->raja_ongkir_url = Config::get('app.RAJA_ONGKIR_URL');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        $shippingMethod = ShippingMethod::get(request('shipping_method'));

        Cart::addShippingMethod($shippingMethod);

        return response()->json([
            'discount' => Cart::discount()->convertToCurrentCurrency()->format(),
            'discount' => Cart::discount()->convertToCurrentCurrency()->format(),
            'total' => Cart::total()->convertToCurrentCurrency()->format(),
        ]);
    }

     public function shippingCost(Request $request)
    {

       $weight_item_kg = Cart::getWeightTotal();
        $destination = $request->session()->get('destination');
        $key = $request->params['courier'].'-'.$this->origin.'-'.$destination.'-'.$weight_item_kg;
        $cache_courier = json_decode(Redis::get($key));
        $shippingMethod = new Method($cache_courier->name, $cache_courier->label, $cache_courier->cost, $cache_courier->destination, $cache_courier->code);
        Cart::addShippingMethod($shippingMethod);
        return response()->json([
            'discount' => Cart::discount()->convertToCurrentCurrency()->format(),
            'shipping_total' => Cart::shippingMethod()->cost(),
            'total' => Cart::total()->convertToCurrentCurrency()->format(),
        ]);
    }


    public function shippingCouriers(Request $request)
    {
        $weight_item_kg = Cart::getWeightTotal();
        $destination = $request->params['district'];
        $request->session()->put('destination', $destination);

        $data = new RajaOngkir;
        $params =  ['origin'           =>  $this->origin,
                    'originType'       => 'subdistrict',
                    'destination'      => $destination,
                    'destinationType'  => 'subdistrict',
                    'weight'           => $weight_item_kg * 1000, //kg to gram
                    'courier'          => 'jne:jnt:sicepat:lion:star:tiki'];
        $response = $data->getCost($params);
        $couriers = [];
        $destination_response = json_encode($response->destination_details);
        foreach($response->results as $result){
            foreach($result->costs as $cost){
                $etd = '';
                if(!empty($cost->cost[0]->etd)){
                    $etd = ' ('.$cost->cost[0]->etd.' '.trans('report::admin.filters.groups.days').')';
                }

                $courier_code = $result->code.'-'.$cost->service;
                $cost_value = $cost->cost[0]->value;
                $couriers[] = ["value" => $courier_code,
                                "text" => strtoupper($result->code).'-'.$cost->service.$etd.', '.Money::inDefaultCurrency($cost_value)->format()];
                $key = $courier_code.'-'.$this->origin.'-'.$destination.'-'.$weight_item_kg;
                $shippingMethod = ['name'  => $result->name,
                                   'label' => $cost->service,
                                    'cost' => $cost_value,
                                    'code' => $result->code,
                                    'destination' => $destination_response];
                Redis::set($key,  json_encode($shippingMethod));
                $day = 24 * (60 * 60);
                Redis::expire($key,  $day);
            }


        }

        return json_encode($couriers);
    }
}
