<?php

namespace FleetCart\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;
use Modules\Product\Entities\Product;
use Modules\Page\Entities\Page;

class SitemapCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sitemap:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sitemap Generate';

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
        $sitemap = Sitemap::create()
            ->add(Url::create('/page/news'))
            ->add(Url::create('/pt-mitsindo-visual-pratama'))
            ->add(Url::create('/contact'));

        $pages = Page::where('category_id', Page::news)->get()->each(function (Page $pages) use ($sitemap) {
            $sitemap->add(Url::create("/page/news/{$pages->slug}"));
        });

        Product::where('is_active',1)->get()->each(function (Product $product) use ($sitemap) {
            $sitemap->add(Url::create("/products/{$product->slug}"));
        });

        $sitemap->writeToFile(public_path('sitemap.xml'));
       $this->info('sitemap.xml has been generated.');
    }
}
