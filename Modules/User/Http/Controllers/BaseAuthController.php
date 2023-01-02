<?php

namespace Modules\User\Http\Controllers;

use Modules\User\Mail\Welcome;
use Modules\User\Mail\WelcomeActivate;
use Modules\User\Entities\Role;
use Modules\User\Entities\User;
use Modules\Company\Entities\Company;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Mail;
use Modules\User\Mail\ResetPasswordEmail;
use Modules\User\Contracts\Authentication;
use Modules\User\Http\Requests\LoginRequest;
use Modules\User\Http\Requests\RegisterRequest;
use Modules\User\Http\Requests\PasswordResetRequest;
use Modules\User\Http\Requests\ResetCompleteRequest;
use Cartalyst\Sentinel\Checkpoints\ThrottlingException;
use Cartalyst\Sentinel\Checkpoints\NotActivatedException;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Auth;


abstract class BaseAuthController extends Controller
{
    /**
     * The Authentication instance.
     *
     * @var \Modules\User\Contracts\Authentication
     */
    protected $auth;

    /**
     * @param \Modules\User\Contracts\Authentication $auth
     */
    public function __construct(Authentication $auth)
    {
        $this->auth = $auth;

        $this->middleware('guest')->except('getLogout');
    }

    /**
     * Where to redirect users after login..
     *
     * @return string
     */
    abstract protected function redirectTo();

    /**
     * The login route.
     *
     * @return string
     */
    abstract protected function loginUrl();

    /**
     * Show login form.
     *
     * @return \Illuminate\Http\Response
     */
    abstract public function getLogin();

    /**
     * Show reset password form.
     *
     * @return \Illuminate\Http\Response
     */
    abstract public function getReset();

    /**
     * Login a user.
     *
     * @param \Modules\User\Http\Requests\LoginRequest $request
     * @return \Illuminate\Http\Response
     */
    public function postLogin(LoginRequest $request)
    {
        try {
            $loggedIn = $this->auth->login([
                'email' => $request->email,
                'password' => $request->password,
            ], (bool) $request->get('remember_me', false));

            if (!$loggedIn) {
                return back()->withInput()
                    ->withError(trans('user::messages.users.invalid_credentials'));
            } else {
                $token = Str::random(80);
                $loggedIn->forceFill([
                    'api_token' => hash('sha256', $token),
                ])->save();
            }
            
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
     * Logout current user.
     *
     * @return void
     */
    public function getLogout(Request $request)
    {
        $request->user()->forceFill([
            'api_token' => null,
        ])->save();
        $this->auth->logout();

        return redirect($this->loginUrl());
    }

    /**
     * Register a user.
     *
     * @param \Modules\User\Http\Requests\RegisterRequest $request
     * @return \Illuminate\Http\Response
     */
    public function postRegister(RegisterRequest $request)
    {
        DB::beginTransaction();
        $user = null;
        try {
            $data = $request->only([
                'first_name',
                'last_name',
                'email',
                'password',
                'position',
                'register_type',
                'company_name'
            ]);

            $data['status'] = User::UNCOMPLETED;
            $user = $this->auth->register($data);
            $activationCode = $this->auth->createActivation($user);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('register')
            ->withError(trans('user::messages.users.account_created_error'));
        }

        if ($user) {
            Mail::to($request->email)
                ->send(new WelcomeActivate($user->first_name, $user->uuid, $activationCode));
        }


        $this->assignCustomerRole($user);

        // if (setting('welcome_email')) {
        //     Mail::to($request->email)
        //         ->send(new Welcome($request->first_name));
        // }

        return redirect($this->loginUrl())
            ->withSuccess(trans('user::messages.users.account_created'));
    }

    protected function assignCustomerRole($user)
    {
        $role = Role::findOrNew(setting('customer_role'));

        if ($role->exists) {
            $this->auth->assignRole($user, $role);
        }
    }

    /**
     * Start the reset password process.
     *
     * @param \Modules\User\Http\Requests\PasswordResetRequest $request
     * @return \Illuminate\Http\Response
     */
    public function postReset(PasswordResetRequest $request)
    {
        $user = User::where('email', $request->email)->first();

        if (is_null($user)) {
            return back()->withInput()
                ->withError(trans('user::messages.users.no_user_found'));
        }

        $code = $this->auth->createReminderCode($user);

        Mail::to($user)
            ->send(new ResetPasswordEmail($user, $this->resetCompleteRoute($user, $code)));

        return back()->withSuccess(trans('user::messages.users.check_email_to_reset_password'));
    }

    /**
     * Reset complete form route.
     *
     * @param \Modules\User\Entities\User $user
     * @param string $code
     * @return string
     */
    abstract protected function resetCompleteRoute($user, $code);

    /**
     * Password reset complete view.
     *
     * @return string
     */
    abstract protected function resetCompleteView();

    /**
     * Show reset password complete form.
     *
     * @param string $email
     * @param string $code
     * @return \Illuminate\Http\Response
     */
    public function getResetComplete($email, $code)
    {
        $user = User::where('email', $email)->firstOrFail();

        if ($this->invalidResetCode($user, $code)) {
            return redirect()->route('reset')
                ->withError(trans('user::messages.users.invalid_reset_code'));
        }

        return $this->resetCompleteView()->with(compact('user', 'code'));
    }

    /**
     * Determine the given reset code is invalid.
     *
     * @param \Modules\User\Entities\User $user
     * @param string $code
     * @return bool
     */
    private function invalidResetCode($user, $code)
    {
        return $user->reminders()->where('code', $code)->doesntExist();
    }

    /**
     * Complete the reset password process.
     *
     * @param string $email
     * @param string $code
     * @param \Modules\User\Http\Requests\ResetCompleteRequest $request
     * @return \Illuminate\Http\Response
     */
    public function postResetComplete($email, $code, ResetCompleteRequest $request)
    {
        $user = User::where('email', $email)->firstOrFail();

        $completed = $this->auth->completeResetPassword($user, $code, $request->new_password);

        if (!$completed) {
            return back()->withInput()
                ->withError(trans('user::messages.users.invalid_reset_code'));
        }

        return redirect($this->loginUrl())
            ->withSuccess(trans('user::messages.users.password_has_been_reset'));
    }
    

    // public function getAutoLogin($key)
    // {
    //     $user = auth()->user();
      
    //     $user = User::where('api_token', $key)->firstOrFail();

    //     if($user){
    //         Auth::login($user); // login user automatically
    //         return redirect()->back()->withMessage('Profile saved!');
    //   }else{
    //     return redirect($this->loginUrl());
    //   }
    // }


    public function getAutoLogin(Request $request)
    {
        // $user = auth()->user();

        // $nonce = session()->get('nonce'); 

        $uri = $request->path();

        dd($uri);
      
        $user = User::where('api_token', $key)->firstOrFail();

        if($user){
            Auth::login($user); // login user automatically
            return redirect()->back()->withMessage('Profile saved!');
      }else{
        return redirect($this->loginUrl());
      }
    }

}
