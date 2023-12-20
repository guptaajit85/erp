<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;
use Validator,Auth, Session, Hash;


class NotificationController extends Controller
{
    
	public function __construct()
    {
         $this->middleware('auth');
    }

    public function index(Request $request)
    { 
            $qsearch =  trim($request->qsearch);
  	        $dataU = User::where('name', 'LIKE', "%$qsearch%")->orderByDesc('id')->get();		
		    
			$comma_string = array();
			foreach ($dataU as $key) 
			{
				$comma_string[] = $key->id;
			}
			$UserIdList = implode(",", $comma_string);
			
 
			$dataI = Notification::whereIn('user_id', explode(",",$UserIdList))->paginate(20);		
			
		    return view('html.notification.show-notifications',compact("dataI","qsearch"));
    }

}