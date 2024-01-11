<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\UserActivityLog;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

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

    // protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function username()
    {
        return 'username';
    }

    public function authenticated($request, $user)
    {
        $activity = new UserActivityLog([
            'activity' => 'Login',
            'created_by' => $user->id,
        ]);
        $activity->save();

        if ($user->role_code == 'RK') {
            return redirect()->action('InventoryController@indexDashboard');
        } elseif ($user->role_code == 'E - Logistic') {
            return redirect()->action('InventoryController@indexDeliveryOrderBc');
        } else {
            return redirect()->route('home');
        }

    }
}
