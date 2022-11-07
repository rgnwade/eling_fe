<?php

namespace Modules\Support\Http\Controllers;

use Modules\Support\State;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Modules\Shipping\RajaOngkir;
use Config;
use Modules\Order\Entities\Order;
class CountryStateController extends Controller
{


    public function states(Request $request)
    {
        $data = new RajaOngkir;
        $response = $data->getProvince();
        return json_encode($response);
    }

    public function cities(Request $request)
    {
        $data = new RajaOngkir;
        $response = $data->getCity(['province' => $request->params['state']]);
        return json_encode($response);

    }

    public function districts(Request $request)
    {
        $data = new RajaOngkir;
        $response = $data->getDistrict(['city' => $request->params['city']]);
        return json_encode($response);
    }

    public function resi(Request $request)
    {

        $order = Order::findOrFail($request->params['order_id']);

        $data = new RajaOngkir;
        $response = $data->getResiInfo(['courier' => $order->shipping_courier_code,
                                        'waybill' => $order->no_resi ]);
        return json_encode($response);
    }
}
