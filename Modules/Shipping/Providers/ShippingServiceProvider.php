<?php

namespace Modules\Shipping\Providers;

use Modules\Shipping\Method;
use Illuminate\Support\ServiceProvider;
use Modules\Shipping\Facades\ShippingMethod;

class ShippingServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        if (! config('app.installed')) {
            return;
        }

        // $this->registerFreeShipping();
        // $this->registerLocalPickup();
        // $this->registerFlatRate();
        $this->registerJnt();
        $this->registerJne();
         $this->registerPos();

    }

    private function registerJne()
    {
        ShippingMethod::register('jne', function () {
            return new Method('jne', 'JNE', 0, 0, 0);
        });
    }

    private function registerJnt()
    {
        ShippingMethod::register('jnt', function () {
            return new Method('jnt', 'J&T', 0, 0, 0);
        });
    }

    private function registerPos()
    {
        ShippingMethod::register('pos', function () {
            return new Method('pos', 'POS', 0, 0, 0);
        });
    }

    private function registerFreeShipping()
    {
        if (! setting('free_shipping_enabled')) {
            return;
        }

        ShippingMethod::register('free_shipping', function () {
            return new Method('free_shipping', setting('free_shipping_label'), 0,0,0);
        });
    }

    private function registerLocalPickup()
    {
        if (! setting('local_pickup_enabled')) {
            return;
        }

        ShippingMethod::register('local_pickup', function () {
            return new Method('local_pickup', setting('local_pickup_label'), setting('local_pickup_cost'),0,0);
        });
    }

    private function registerFlatRate()
    {
        if (! setting('flat_rate_enabled')) {
            return;
        }

        ShippingMethod::register('flat_rate', function () {
            return new Method('flat_rate', setting('flat_rate_label'), setting('flat_rate_cost'),0,0);
        });
    }
}
