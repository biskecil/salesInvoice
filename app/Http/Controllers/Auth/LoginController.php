<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    public function getDataVenueSearch(Request $request)
    {
        $search = $request->get('q'); // Ambil query pencarian dari Select2

        $venue_list = DB::table('venue')
            ->when($search, function ($query, $search) {
                $query->where('Description', 'like', "%{$search}%");
            })
            ->orderBy('Description', 'ASC')
            ->limit(50)
            ->get();

        return response()->json($venue_list);
    }

    protected function authenticated(Request $request, $user)
    {
        Session::put('event', $request->event);
        Session::put('venue', $request->venue);
    }

    // protected function validateLogin(Request $request)
    // {
    //     $request->validate([
    //         $this->username() => 'required|string',
    //         'password' => 'required|string',
    //         'event' => 'required',
    //         'venue' => 'required',
    //     ]);
    // }


    public function logout(Request $request)
    {
        Session::forget('event');
        Session::forget('pameran');

        $this->guard()->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();
        

        if ($response = $this->loggedOut($request)) {
            return $response;
        }

        return $request->wantsJson()
            ? new JsonResponse([], 204)
            : redirect('/');
    }


    public function username()
    {
        return 'username';
    }
}
