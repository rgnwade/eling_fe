<?php

namespace Modules\Coupon\Checkers;

use Closure;
use Modules\Cart\Facades\Cart;
use Modules\Coupon\Exceptions\InapplicableCouponException;
use Carbon\Carbon;
use Modules\Order\Entities\Order;

class OnlyNewCustomer
{
    public function handle($coupon, Closure $next)
    {
        $coupon->load('products');

        if (!$coupon->usage_only_for_new_customer) {
            return $next($coupon);
        }
        if (empty(auth()->user())) {
            throw new InapplicableCouponException;
        }
        if (auth()->user()->created_at->diff(Carbon::now())->days > 30) {
            throw new InapplicableCouponException;
        }
        $order = Order::where('customer_id', auth()->user()->id)
        ->whereIn('status', ['completed', 'processing','buyer_completed','in_shipping','received'])
        ->count();
        if ($order >  1) {
            throw new InapplicableCouponException;
        }
        return $next($coupon);
    }
}
