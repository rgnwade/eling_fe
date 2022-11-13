<?php

namespace Modules\Order\Http\Requests;

use Modules\Support\Country;
use Illuminate\Validation\Rule;
use Modules\Payment\Facades\Gateway;
use Modules\Core\Http\Requests\Request;
use Modules\Shipping\Facades\ShippingMethod;

class StoreOrderRequest extends Request
{
    /**
     * Available attributes.
     *
     * @var string
     */
    protected $availableAttributes = 'storefront::checkout.tabs.attributes';

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'customer_email' => ['required', 'email', $this->emailUniqueRule()],
            'billing.first_name' => 'required',
            'billing.last_name' => 'required',
            'billing.address_1' => 'required',
            'billing.city' => 'required',
            'billing.courier' => 'required',
            // 'billing.country' => ['required', Rule::in(Country::supportedCodes())],
            'billing.state' => 'required',
            'billing.city' => 'required',
            'billing.district' => 'required',
            'create_an_account' => 'boolean',
            'password' => 'required_if:create_an_account,1',
            'ship_to_different_address' => 'boolean',
            'shipping.first_name' => 'required_if:ship_to_a_different_address,1',
            'shipping.last_name' => 'required_if:ship_to_a_different_address,1',
            'shipping.address_1' => 'required_if:ship_to_a_different_address,1',
            'shipping.city' => 'required_if:ship_to_a_different_address,1',
            'shipping.zip' => 'required_if:ship_to_a_different_address,1',
            'shipping.country' => ['required_if:ship_to_a_different_address,1', Rule::in(Country::supportedCodes())],
            'shipping.state' => 'required_if:ship_to_a_different_address,1',
            'payment_method' => ['required', Rule::in(Gateway::names())],
            'terms_and_conditions' => 'accepted',
            'payment_term' => 'required',
        ];
    }

    private function emailUniqueRule()
    {
        return $this->create_an_account ? Rule::unique('users', 'email') : null;
    }
}
