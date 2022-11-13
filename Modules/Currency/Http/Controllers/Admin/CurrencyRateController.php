<?php

namespace Modules\Currency\Http\Controllers\Admin;

use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Admin\Traits\HasCrudActions;
use Modules\Currency\Entities\CurrencyRate;
use Modules\Currency\Services\CurrencyRateExchanger;
use Modules\Currency\Http\Requests\UpdateCurrencyRateRequest;
use FleetCart\Jobs\RefreshProductRate;
class CurrencyRateController extends Controller
{
    use HasCrudActions;

    /**
     * Model for the resource.
     *
     * @var string
     */
    protected $model = CurrencyRate::class;

    /**
     * Label of the resource.
     *
     * @var string
     */
    protected $label = 'currency::currency_rates.currency_rate';

    /**
     * View path of the resource.
     *
     * @var string
     */
    protected $viewPath = 'currency::admin.currency_rates';

    /**
     * Form requests for the resource.
     *
     * @var array
     */
    protected $validation = UpdateCurrencyRateRequest::class;

    /**
     * Refresh currency rates.
     *
     * @param \Modules\Currency\Services\CurrencyRateExchanger $exchanger
     * @return \Illuminate\Http\Response
     */
    public function refresh(CurrencyRateExchanger $exchanger)
    {
        if (is_null(setting('currency_rate_exchange_service'))) {
            abort(Response::HTTP_NOT_ACCEPTABLE, trans('currency::messages.exchange_service_is_not_configured'));
        }

        CurrencyRate::refreshRates($exchanger);
    }


    public function update($id)
    {
        $entity = $this->getEntity($id);

        $this->disableSearchSyncing();

        $entity->update(
            $this->getRequest('update')->all()
        );

        $this->createLog($entity, 'edit', $this->getRequest('update'));
        
        RefreshProductRate::dispatch();

        $this->searchable($entity);

        if (method_exists($this, 'redirectTo')) {
            return $this->redirectTo($entity)
                ->withSuccess(trans('admin::messages.resource_saved', ['resource' => $this->getLabel()]));
        }

        return redirect()->back()
            ->withSuccess(trans('admin::messages.resource_saved', ['resource' => $this->getLabel()]));
    }
}
