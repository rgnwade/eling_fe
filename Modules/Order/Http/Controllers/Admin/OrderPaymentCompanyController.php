<?php

namespace Modules\Order\Http\Controllers\Admin;

use Illuminate\Routing\Controller;
use Modules\Admin\Traits\HasCrudActions;
use Modules\Order\Entities\OrderPaymentCompany;
use Modules\Order\Http\Requests\StoreOrderCompanyPaymentRequest;
use Illuminate\Http\Request;

class OrderPaymentCompanyController extends Controller
{
    use HasCrudActions;

    /**
     * Model for the resource.
     *
     * @var string
     */
    protected $model = OrderPaymentCompany::class;

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = [];

    /**
     * Label of the resource.
     *
     * @var string
     */
    protected $label = 'order::orders.order';

    /**
     * View path of the resource.
     *
     * @var string
     */
    protected $viewPath = 'order::admin.orders_vendor';

    /**
     * Form requests for the resource.
     *
     * @var array
     */
    protected $validation = StoreOrderCompanyPaymentRequest::class;


    public function store()
    {
        $this->disableSearchSyncing();

        $entity = $this->getModel()->create(
            $this->getRequest('store')->all()
        );

        $this->createLog($entity, 'create', $this->getRequest('store'));

        $this->searchable($entity);

        if (method_exists($this, 'redirectTo')) {
            return $this->redirectTo($entity);
        }

        return redirect()->back()
            ->withSuccess(trans('admin::messages.resource_saved', ['resource' => $this->getLabel()]));
    }

    public function destroy($ids, Request $request)
    {
        foreach(explode(',', $ids) as $id){
            $this->createDestroyLog($this->getModel(), 'delete', $request, $id);
        }

        $this->getModel()
            ->withoutGlobalScope('active')
            ->whereIn('id', explode(',', $ids))
            ->delete();

            return redirect()->back()
            ->withSuccess(trans('admin::messages.resource_deleted', ['resource' => $this->getLabel()]));
    }

}
