<?php

namespace Modules\User\Http\Requests;

use Modules\Core\Http\Requests\Request;
use Illuminate\Validation\Rule;
class RegisterRequest extends Request
{
    /**
     * Available attributes.
     *
     * @var string
     */
    protected $availableAttributes = 'user::attributes.users';

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:users',
            'company_name' => Rule::requiredIf(request()->register_type != 'customer_b2c'),
            'position' =>  Rule::requiredIf(request()->register_type != 'customer_b2c'),
            'register_type' => 'required',
            'password' => 'required|confirmed|min:6',
            'captcha' => 'required|captcha',
            'privacy_policy' => 'accepted',
        ];
    }
}
