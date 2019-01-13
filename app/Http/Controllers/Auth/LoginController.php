<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;

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
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        if(Session::has('selected.database'))
        {
            Config::set('database.default',Session::get('selected.database'));
        }
    }

    /**
     * Check either username or email.
     * @return string
     */
    public function username()
    {
        $identity  = request()->get('identity');
        $email = $identity;
        $fieldName = 'email';
        if(strpos($identity, "\\") !== false) {
            $identitySplited = explode("\\", $identity);
            $domain = $identitySplited[0];
            $email = $identitySplited[1];

            if (Config::get('database.connections.'.$domain, '') != '') {
                Config::set('database.default', $domain);
                Session::put('selected.database', $domain);
            }
        }

        request()->merge([$fieldName => $email]);
        return $fieldName;
    }

//    protected function authenticated(Request $request, $user)
//    {
////        var_dump('authenticated');
////        var_dump(Config::get('database.default'));
////        var_dump($user);die;
//        Config::set('database.default',Session::get('selected.database'));
//    }


}
