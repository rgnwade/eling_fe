<?php

namespace FleetCart\Console\Commands;

use Illuminate\Console\Command;
use Modules\Product\Entities\Product;
use Illuminate\Support\Facades\DB;

class UpdateProductsKeyword extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'keyword:product';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $products = Product::get();
        $this->info($products->count());
        foreach ($products as $product) {
            $keyword = $product->name;
            if ($product->merkName()) {
                $keyword =  $product->merkName() . " " . $product->name;
            }
            DB::table('products')
                ->where('id', $product->id)
                ->update(['keyword' =>  $keyword]);
            $this->info($product->id . " -> ok");
        }
        $this->info("ok");
    }
}
