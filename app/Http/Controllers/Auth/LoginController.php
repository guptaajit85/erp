<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\UserWebPage;
use App\Models\AllPage;
use App\Providers\RouteServiceProvider; // Correct the namespace for RouteServiceProvider
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected function authenticated(Request $request, $user)
    {
		// Fetch and store user web pages in session
		$userId = $user->id;
		$userWebPages = UserWebPage::where('user_id', $userId)->get();
		session(['userWebPages' => $userWebPages]);
		 

		$allPages = AllPage::where('status', 1)->get();
		session(['allPages' => $allPages]);
		 // echo "<pre>"; print_r(session()->all()); exit;
		// Continue with the default behavior
		return redirect()->intended(RouteServiceProvider::HOME); // Correct the reference to RouteServiceProvider
    }

    protected $redirectTo = RouteServiceProvider::HOME; // Correct the reference to RouteServiceProvider

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}

