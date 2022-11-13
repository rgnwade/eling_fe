<?php

namespace Modules\Checkout\Services;

use Modules\Cart\Facades\Cart;
use Modules\Order\Entities\Order;
use Modules\Currency\Entities\CurrencyRate;
use Modules\Shipping\Facades\ShippingMethod;
use Modules\Support\Money;
use Modules\Company\Entities\Company;

class OrderService
{
    public function create($request)
    {
        $this->mergeShippingAddress($request);
        $this->addShippingMethodToCart($request);

        return tap($this->store($request), function ($order) {
            $this->storeOrderPayments($order);
            $this->storeOrderProducts($order);
            $this->storeOrderCompanies($order);
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
        if (!Cart::hasShippingMethod()) {
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
            'billing_zip' => $request->billing['zip'],
            'billing_country' => 'ID',
            'shipping_first_name' => $request->billing['first_name'],
            'shipping_last_name' => $request->billing['last_name'],
            'shipping_address_1' => $request->billing['address_1'],
            'shipping_address_2' => $request->billing['address_2'],
            'shipping_city' => $destination->city,
            'shipping_state' => $destination->province,
            'shipping_zip' => $request->billing['zip'],
            'shipping_country' => "ID",
            'sub_total' => Cart::subTotal()->amount(),
            'shipping_method' => Cart::shippingMethod()->name() . '-' . Cart::shippingMethod()->label(),
            'shipping_courier_code' => Cart::shippingMethod()->courier_code(),
            'shipping_cost' => Cart::shippingCost()->amount(),
            'coupon_id' => Cart::coupon()->id(),
            'discount' => Cart::discount()->amount(),
            'weight_total' => Cart::getWeightTotal(),
            'dimension_total' => Cart::getDimensionTotal(),
            'total' => Cart::total()->amount(),
            'payment_method' => $request->payment_method,
            'currency' => currency(),
            'currency_rate' => CurrencyRate::for(currency()),
            'locale' => locale(),
            'status' => Order::PENDING_PAYMENT,
            'payment_term' => $request->payment_term
        ]);
    }

    private function storeOrderPayments($order)
    {
        $down_payment_percent =  !empty(Cart::paymentTerm()->down_payment_percent) ? Cart::paymentTerm()->down_payment_percent : 0;
        $down_payment_amount =   !empty(Cart::paymentTerm()->down_payment_percent) ? (Cart::total()->amount() * Cart::paymentTerm()->down_payment_percent) : 0;
        if ($down_payment_amount > 0) {
            $order->storePayments([
                'amount'            => $down_payment_amount,
                'percent_of_total'  => $down_payment_percent,
                'currency'          => 'IDR',
                'payment_method'    => $order->payment_method,
                'status'            => 'pending',
                'remarks'           => '',
                'type'              => 'down_payment'
            ]);

            $order->storePayments([
                'amount'            => $order->total->amount() - $down_payment_amount,
                'percent_of_total'  => 1 - $down_payment_percent, //100% - 30% = 70%
                'currency'          => 'IDR',
                'payment_method'    => $order->payment_method,
                'status'            => 'upcoming',
                'remarks'           => '',
                'type'              => 'completion_payment'
            ]);
        } else {
            $order->storePayments([
                'amount'            => $order->total->amount(),
                'percent_of_total'  => 1,
                'currency'          => 'IDR',
                'payment_method'    => $order->payment_method,
                'status'            => 'pending',
                'remarks'           => '',
                'type'              => 'full_payment'
            ]);
        }
    }

    private function storeOrderProducts($order)
    {
        Cart::items()->each(function ($cartItem) use ($order) {
            $order->storeProducts($cartItem);
        });
    }

    private function storeOrderCompanies($order)
    {
        $items = Cart::items();
        $company_ids = $items->pluck('product.company.id')->unique()->flatten();

        $order_products_companies = $items->groupBy('product.company.id');
        $order_products_companies =  $order_products_companies->map(function ($item, $key) {
            $item = (object) $item;
            $currency = $item->first()->product->vendor_currency;
            return  (object) [
                'company' => Company::find($key),
                'total' => Money::inDefaultCurrency($item->sum('total'), $currency),
                'total_vendor' => Money::inVendorCurrency($item->sum('total_vendor'), $currency)
            ];
        });

        foreach($order_products_companies as $order_products_company){
                 $order->storeOrderCompanies($order_products_company);
        }
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
