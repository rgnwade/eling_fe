<?php

namespace Modules\Support\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Modules\Company\Entities\Country;

class CountryController extends Controller
{
    public function index(Request $request)
    {
        $countries = Country::get();
        return json_decode($countries);
    }
}
