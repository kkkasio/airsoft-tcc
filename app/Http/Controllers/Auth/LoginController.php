<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Socialite;


class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    //protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /* public function login(Request $request)
    {

        $this->validateLogin($request);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }
        if ($this->guard()->validate($this->credentials($request))) {
            $user = $this->guard()->getLastAttempted();

            if ($user->ativo && $this->attemptLogin($request)) {
                return $this->sendLoginResponse($request);
            } else {
                $this->incrementLoginAttempts($request);

                switch ($user) {
                    case !$user->ativo:
                        return redirect()
                            ->back()
                            ->withInput($request->only($this->username(), 'remember'))
                            ->with(['info' => 'Para proseguir você deve confirmar a sua conta, foi enviado um link para seu email.']);
                        //                    case !$user->confirmado:
                        //                        return redirect()
                        //                            ->back()
                        //                            ->withInput($request->only($this->username(), 'remember'))
                        //                            ->with(['info' => 'Sua instituição não está confirmada, você deve aguardar um administrador confirmar a autenticidade da instituição.']);
                    default:
                        return redirect()
                            ->back()
                            ->withInput($request->only($this->username(), 'remember'))
                            ->with(['info' => 'Tente fazer o login novamente.']);
                }
            }
        }
        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }*/

    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function redirectToGithub()
    {
        return Socialite::driver('github')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {

            $user = Socialite::driver('google')->user();
            $finduser = User::where('email', $user->email)->first();

            if ($finduser) {

                Auth::login($finduser);

                if ($finduser->type === 'Membro') {
                    return redirect()->route('membro-dashboard');
                } else {
                    return redirect()->route('liga-dashboard');
                }
            }
            toastr()->error('Ops... não encontramos um usuário válido');
            return redirect()->route('login');
        } catch (Exception $e) {
            toastr()->error('Ops... não encontramos um usuário válido');
            return redirect('login');
        }
    }

    public function handleGithubCallback()
    {
        try {

            $user = Socialite::driver('github')->user();
            $finduser = User::where('email', $user->email)->first();

            if ($finduser) {

                Auth::login($finduser);

                if ($finduser->type === 'Membro') {
                    return redirect()->route('membro-dashboard');
                } else {
                    return redirect()->route('liga-dashboard');
                }
            }
            toastr()->error('Ops... não encontramos um usuário válido');
            return redirect()->route('login');
        } catch (Exception $e) {
            toastr()->error('Ops... não encontramos um usuário válido');
            return redirect('login');
        }
    }

    public function authenticated(Request $request, $user)
    {
        if ($user->type === 'Membro') {
            return redirect()->route('membro-dashboard');
        } else {
            return redirect()->route('liga-dashboard');
        }
    }
}
