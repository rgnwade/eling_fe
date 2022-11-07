<?php

namespace Modules\Checkout\Services;

use Modules\Cart\Facades\Cart;
use Modules\Order\Entities\Order;
use Modules\Currency\Entities\CurrencyRate;
use Modules\Shipping\Facades\ShippingMethod;

class OrderService
{
    public function create($request)
    {
        $this->mergeShippingAddress($request);
        $this->addShippingMethodToCart($request);

        return tap($this->store($request), function ($order) {
            $this->storeOrderProducts($order);
            $this->incrementCouponUsage($order);
            $this->attachTaxes($order);
            $this->reduceStock();
        });
    }

    private function mergeShippingAddress($request)
    {
        $request->merge([
            'shipping' => $request->ship_to_a_different_address ? $request->shipping : $request->billing,
        ]);
    }

    private function addShippingMethodToCart($request)
    {
        if (! Cart::hasShippingMethod()) {
            Cart::addShippingMethod(ShippingMethod::get($request->shipping_method));
        }
    }

    private function store($request)
    {
        $destination = Cart::shippingMethod()->destination();
        return Order::create([
            'customer_id' => auth()->id(),
            'customer_email' => $request->customer_email,
            'customer_phone' => $request->customer_phone,
            'customer_first_name' => $request->billing['first_name'],
            'customer_last_name' => $request->billing['last_name'],
            'billing_first_name' => $request->billing['first_name'],
            'billing_last_name' => $request->billing['last_name'],
            'billing_address_1' => $request->billing['address_1'],
            'billing_address_2' => $request->billing['address_2'],
            'billing_city' => $destination->city,
            'district' => $destination->subdistrict_name,
            'billing_state' =>  $destination->province,
            'billing_zip' => 0,
            'billing_country' => 'ID',
            'shipping_first_name' => $request->billing['first_name'],
            'shipping_last_name' => $request->billing['last_name'],
            'shipping_address_1' => $request->billing['address_1'],
            'shipping_address_2' => $request->billing['address_2'],
            'shipping_city' => $destination->city,
            'shipping_state' => $destination->province,
            'shipping_zip' => 0,
            'shipping_country' =>"ID",
            'sub_total' => Cart::subTotal()->amount(),
            'shipping_method' => Cart::shippingMethod()->name().'-'.Cart::shippingMethod()->label(),
            'shipping_courier_code' => Cart::shippingMethod()->courier_code(),
            'shipping_cost' => Cart::shippingCost()->amount(),
            'coupon_id' => Cart::coupon()->id(),
            'discount' => Cart::discount()->amount(),
            'weight_total' => Cart::getWeightTotal(),
            'total' => Cart::total()->amount(),
            'payment_method' => $request->payment_method,
            'currency' => currency(),
            'currency_rate' => CurrencyRate::for(currency()),
            'locale' => locale(),
            'status' => Order::PENDING_PAYMENT,
        ]);
    }

    private function storeOrderProducts($order)
    {
        Cart::items()->each(function ($cartItem) use ($order) {
            $order->storeProducts($cartItem);
        });
    }

    private function incrementCouponUsage()
    {
        Cart::coupon()->usedOnce();
    }

    private function attachTaxes($order)
    {
        Cart::taxes()->each(function ($cartTax) use ($order) {
            $order->attachTax($cartTax);
        });
    }

    public function reduceStock()
    {
        Cart::reduceStock();
    }

    public function delete($order)
    {
        $order->delete();

        Cart::restoreStock();
    }
}
