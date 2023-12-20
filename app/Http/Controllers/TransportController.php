<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Models\Transport;
use App\Models\Person;
use App\Models\Individual;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
 use Auth;
use Validator, Session, Hash;

class TransportController extends Controller
{
	public function __construct()
    {
         $this->middleware('auth');
    }
    public function index(Request $request, $id)
    { 

        
		// echo "<pre>";  print_r($request->all()); exit; 
		// error_reporting(0);
		 
		$qsearch =  $request->qsearch;
        $indID = base64_decode($id);	 
		$dataI = Individual::where('id', $indID)->first();
		$dataP = Transport::where('status', '=', '1')->paginate(20); 
		// echo "<pre>";  print_r($dataI); exit; 
		return view('html.transport.show-transports',compact("dataP","qsearch","dataI"));  
    }
	
    public function edit_transport ($id)
	{
		$id = base64_decode($id);
		$data = Transport::where('id', $id)->first();
		$indID = $data->individual_id;
        $dataI = Individual::where('id', $indID)->first(); 	
		return view('html.transport.edit-transport',compact("data","dataI"));
	}

	
	 


    public function create_transport($id)
    {
		$indID = base64_decode($id);
		$data = Individual::where('id', $indID)->first(); 		 
		return view('html.transport.add-transport',compact("data","indID"));
    }

	public function store_transport(Request $request )
    {
        
	  // echo "<pre>"; print_r($request->all()); exit;
		
		 
        $userId = Auth::id();	
		$obj = new Transport;

        $obj->individual_id  		= $request->individual_id;		
		//$obj->name  			    = $request->name;
		$obj->transport_from  		= $request->transport_from;
		$obj->transport_to  		= $request->transport_to;
		$obj->created_by  					= $userId;
		$obj->modified_by  					= $userId; 
		
		$obj->status  				= 1;
		$obj->created  				= date("Y-m-d H:i:s");
		$obj->modified  			= date("Y-m-d H:i:s");
		$is_saved 					= $obj->save();
		if($is_saved)
		{
			Session::put('message', 'Added successfully.');
			Session::put("messageClass","successClass");
			 
            return redirect("/show-transports/".base64_encode($obj->individual_id));
		}

    }
	


	public function update_transport(Request $request)
    {
		
	//  echo "<pre>"; print_r($request->all()); exit;
		
	   
	 
		$obj = Transport::where('id','=', $request->id)->first();
       
       $userId = Auth::id();	
      	 
		
	//	$obj->name  					    = $request->name;
		$obj->transport_from  				= $request->transport_from;
		$obj->transport_to  				= $request->transport_to;
		$obj->created_by  					= $userId;
		$obj->modified_by  					= $userId;
		$obj->status  				= 1;
		$obj->created  				= date("Y-m-d H:i:s");
		$obj->modified  			= date("Y-m-d H:i:s");
		$is_saved 					= $obj->save();

		if($is_saved)
		{
			Session::put('message', 'Updated successfully.');
			Session::put("messageClass","successClass");
			return redirect("/show-transports/".base64_encode($request->individual_id));
		}

    }

    public function deleteTransport(Request $request)
    {
		$FId 	= $request->FId;
		$obj 	= Transport::find($FId);
		$obj->status  = '0';
		$obj->save();
		return $FId;
    }



    public function destroy($id)
    {
        //
    }
}
