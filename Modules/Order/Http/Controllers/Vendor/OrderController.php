<?php

namespace Modules\Order\Http\Controllers\Vendor;

use Modules\Order\Entities\Order;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Admin\Traits\HasCrudActions;
use Modules\Order\Entities\CompanyOrder;
use Modules\Order\Http\Requests\SaveOrderRequest;
use Modules\Order\Mail\OrderVendorStatusChanged;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{
    use HasCrudActions;

    /**
     * Model for the resource.
     *
     * @var string
     */
    protected $model = CompanyOrder::class;

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = ['products'];

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
    protected $viewPath = 'order::vendor.orders';

    /**
     * Form requests for the resource.
     *
     * @var array|string
     */
    protected $validation = SaveOrderRequest::class;

    public function index(Request $request)
    {
        if ($request->has('query')) {
            return $this->getModel()
                ->search($request->get('query'))
                ->query()
                ->limit($request->get('limit', 10))
                ->get();
        }

        if ($request->has('table')) {
            return $this->getModel()->tableVendor($request);
        }

        return view("{$this->viewPath}.index");
    }

    public function show($id)
    {
        $order = Order::findOrFail($id);
        $company_id = auth()->user()->company_id;
        $items = $order->filterByCompany($company_id);
        if ($items->isEmpty()) {
            return redirect()->back()->withError('Error');
        }
        $company_order = $order->getStatusByCompany($company_id);
        $payments = $order->filterPaymentByCompany($company_id);

        return view("{$this->viewPath}.show")
            ->with('order', $order)
            ->with('company_order', $company_order)
            ->with('order_products', $items)
            ->with('payments', $payments);
    }

    public function update(SaveOrderRequest $request, $id)
    {
        $order = Order::find($id);
        $company_id =  auth()->user()->company_id;
        $items = $order->filterByCompany($company_id);
        if ($items->isEmpty()) {
            return redirect()->back()->withError('Error');
        }

        $order->getStatusByCompany($company_id)->update(['status' => request()->status]);
        $notif_receiving_emails = explode(',', setting('notif_receiving_emails'));
        foreach ($notif_receiving_emails as $notif_receiving_email) {
            $email = preg_replace('/\s+/', '', $notif_receiving_email);
            Mail::to($email)
                ->send(new OrderVendorStatusChanged($order, $company_id, request()->status));
        }



        if (method_exists($this, 'redirectTo')) {
            return $this->redirectTo($order)
                ->withSuccess(trans('admin::messages.resource_saved', ['resource' => trans($this->label)]));
        }

        return redirect()->back()
            ->withSuccess(trans('admin::messages.resource_saved', ['resource' => trans($this->label)]));
    }
}
