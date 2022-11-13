<?php

namespace Modules\User\Http\Controllers\Vendor;

use Modules\User\Http\Controllers\BaseAuthController;
use Modules\Core\Http\Traits\LogTrait;
use Modules\User\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use Cartalyst\Sentinel\Checkpoints\NotActivatedException;
use Cartalyst\Sentinel\Checkpoints\ThrottlingException;
use Illuminate\Support\Str;
class AuthController extends BaseAuthController
{
    use LogTrait;
    /**
     * Where to redirect users after login..
     *
     * @return string
     */
    protected function redirectTo()
    {
        return route('vendor.products.index');
    }

    public function getLogout(Request $request)
    {
        $this->createDefaultLog('User', '', 'logout', $request);
        $request->user()->forceFill(['api_token' => null])->save();
        $this->auth->logout();

        return redirect($this->loginUrl());
    }

     public function postLogin(LoginRequest $request)
    {
        try {
            $loggedIn = $this->auth->login([
                'email' => $request->email,
                'password' => $request->password,
            ], (bool) $request->get('remember_me', false));

            if (! $loggedIn) {
                return back()->withInput()
                    ->withError(trans('user::messages.users.invalid_credentials'));
            }

            if(!$this->auth->user()->hasRoleName('seller')){
                $this->auth->logout();
                return back()->withInput()
                ->withError(trans('user::messages.users.invalid_credentials'));
            }
            $token = Str::random(80);
            $loggedIn->forceFill([
                'api_token' => hash('sha256', $token),
            ])->save();

            $this->createDefaultLog('User', '', 'login', $request);

            return redirect()->intended($this->redirectTo());
        } catch (NotActivatedException $e) {
            return back()->withInput()
                ->withError(trans('user::messages.users.account_not_activated'));
        } catch (ThrottlingException $e) {
            return back()->withInput()
                ->withError(trans('user::messages.users.account_is_blocked', ['delay' => intl_number($e->getDelay())]));
        }
    }

    /**
     * The login URL.
     *
     * @return string
     */
    protected function loginUrl()
    {
        return route('vendor.login');
    }

    /**
     * Show login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function getLogin()
    {

        return view('user::vendor.auth.login');
    }

    /**
     * Show reset password form.
     *
     * @return \Illuminate\Http\Response
     */
    public function getReset()
    {
        return view('user::vendor.auth.reset.begin');
    }

    /**
     * Reset complete form route.
     *
     * @param \Modules\User\Entities\User $user
     * @param string $code
     * @return string
     */
    protected function resetCompleteRoute($user, $code)
    {
        return route('vendor.reset.complete', [$user->email, $code]);
    }

    /**
     * Password reset complete view.
     *
     * @return string
     */
    protected function resetCompleteView()
    {
        return view('user::vendor.auth.reset.complete');
    }
}
