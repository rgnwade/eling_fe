<?php

namespace Modules\Currency\Entities;

use Money\Currency;
use Modules\Support\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Modules\Currency\Admin\CurrencyRateTable;
use Modules\Currency\Services\CurrencyRateExchanger;

class CurrencyRate extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['currency', 'rate'];

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    public static function boot()
    {
        parent::boot();

        static::saved(function ($currencyRate) {
            Cache::forget("currency_rate.{$currencyRate->currency}");
        });
    }

    /**
     * Refresh all supported currencies exchange rate.
     *
     * @param \Modules\Currency\Services\CurrencyRateExchanger $exchanger
     * @return void
     */
    public static function refreshRates(CurrencyRateExchanger $exchanger)
    {
        $fromCurrency = setting('default_currency');

        foreach (setting('supported_currencies') as $toCurrency) {
            $rate = $exchanger->exchange($fromCurrency, $toCurrency);

            static::where('currency', $toCurrency)->first()->update(['rate' => $rate]);
        }
    }

    public static function currentUSD()
    {
       return  static::where('currency', 'USD')->first()->rate;
    }

    /**
     * Get currency rate for the given currency.
     *
     * @param string $currency
     * @return int|float
     */
    public static function for($currency)
    {
        return Cache::rememberForever("currency_rate.{$currency}", function () use ($currency) {
            return static::where('currency', $currency)->value('rate');
        });
    }

    /**
     * Get table data for the resource
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function table()
    {
        return new CurrencyRateTable($this->newQuery());
    }
}
