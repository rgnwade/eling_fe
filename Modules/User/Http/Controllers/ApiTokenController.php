<?php

namespace Modules\User\Http\Controllers;

use Illuminate\Routing\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Modules\User\Entities\User;


class ApiTokenController extends Controller
{
    /**
     * Update the authenticated user's API token.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function validate(Request $request)
    {
        $token = $request->token;
        $user_id = $request->userId;

        if ($token == null || $user_id == null) {
            return 'false';
        }

        $user = User::where('api_token', $token)->first();
        $encrypted =  hash('sha256', $token);
        if ($user != null && $user->uuid == $user_id) {
            return 'true';
        }else{
            return 'false';
        }

    }
}
