<?php

namespace Modules\User\Http\Controllers\Admin;

use Illuminate\Routing\Controller;
use Modules\Admin\Ui\Facades\TabManager;
use Modules\User\Http\Requests\UpdateProfileRequest;
use Modules\User\Http\Requests\EnableGoogle2FaRequest;
use Illuminate\Support\Facades\Auth;
use Modules\Core\Http\Requests\Request;

class ProfileController extends Controller
{
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        $tabs = TabManager::get('profile');

        return view('user::admin.profile.edit', compact('tabs'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Modules\User\Http\Requests\UpdateProfileRequest $request
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProfileRequest $request)
    {
        $this->bcryptPassword($request);

        auth()->user()->update($request->all());

        return back()->withSuccess(trans('admin::messages.resource_saved', [
            'resource' => trans('user::users.profile'),
        ]));
    }

    public function getLogin()
    {
        return view('public.auth.login');
    }

    public function getGoogle2Fa()
    {
        $user = Auth()->user();
        $google2fa = app('pragmarx.google2fa');
        $secret = $google2fa->generateSecretKey();

        $qr = $google2fa->getQRCodeInline(
            config('app.name'),
            $user->email,
            $secret
        );
         return view('user::admin.google2fa.index', compact('qr','secret' ));
    }

    public function postGoogle2Fa(EnableGoogle2FaRequest $request)
    {
        $google2fa = app('pragmarx.google2fa');
        $secret = $request->input('secret');
        $google2fa_secret = $request->input('google2fa_secret');

        $valid = $google2fa->verifyKey($google2fa_secret, $secret);
        if(!$valid){
            return back()->withError('invalid key');
        }

        auth()->user()->update($request->all());

        return back()->withSuccess(trans('admin::messages.resource_saved', [
        'resource' => trans('user::users.google2fa'),]));
    }

    /**
     * Bcrypt user password.
     *
     * @param \Illuminate\Http\Request $request
     * @return void
     */
    private function bcryptPassword($request)
    {
        if ($request->filled('password')) {
            return $request->merge(['password' => bcrypt($request->password)]);
        }

        unset($request['password']);
    }
}
