<?php

namespace Modules\User\Http\Controllers\Admin;

use Modules\User\Http\Controllers\BaseAuthController;
use Modules\Core\Http\Traits\LogTrait;
use Modules\User\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
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
        return route('admin.dashboard.index');
    }

    public function getLogout(Request $request)
    {
        $this->createDefaultLog('User', '', 'logout', $request);
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
        return route('admin.login');
    }

    /**
     * Show login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function getLogin()
    {
        return view('user::admin.auth.login');
    }

    /**
     * Show reset password form.
     *
     * @return \Illuminate\Http\Response
     */
    public function getReset()
    {
        return view('user::admin.auth.reset.begin');
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
        return route('admin.reset.complete', [$user->email, $code]);
    }

    /**
     * Password reset complete view.
     *
     * @return string
     */
    protected function resetCompleteView()
    {
        return view('user::admin.auth.reset.complete');
    }
}
