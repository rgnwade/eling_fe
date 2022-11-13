<?php

namespace FleetCart\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Modules\Currency\Entities\CurrencyRate;
use Modules\Product\Entities\Product;
use Illuminate\Support\Facades\DB;

class RefreshProductRate implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $products = Product::withoutGlobalScope('active')->where('price_formula', 'LIKE', '%$rate%')->get();

        foreach ($products as $product) {
            $price = $this->calculatePrice($product->price_formula, $product->vendor_price->amount());
            DB::table('products')
                ->where('id',$product->id)
                ->update(['price' => $price]);
        }
    }

    private function calculatePrice($formula, $vendor_price)
    {
        $rate = CurrencyRate::currentUSD();
        $result = 0;
        eval('$result = ' . $formula . ';');
        $result = round($result, -3);
        return $result;
    }
}
