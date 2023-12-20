<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Person;
use App\Models\Individual;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;
use Validator, Session, Hash;


class CustomerController extends Controller
{
    public function __construct()
    {
         $this->middleware('auth');
    }
 
    public function index(Request $request, $id)
    {  
		$qsearch =  trim($request->qsearch);
        $indID = base64_decode($id);	 
		$dataI = Individual::where('id', $indID)->first();
		$dataP = Customer::where('individual_id', '=', $indID)->where('status', '=', '1')->paginate(20); 
		
       //  echo "<pre>";  print_r($dataP); exit; 
		return view('html.customer.show-customers',compact("dataP","qsearch","dataI"));  
    }
	
    public function edit_customer ($id)
	{
		$id = base64_decode($id);
		$data = Customer::where('id', $id)->first();
		$indID = $data->individual_id;
        $dataI = Individual::where('id', $indID)->first(); 	        
		return view('html.customer.edit-customer',compact("data","dataI"));
	}

    public function create_customer($id)
    {
		$indID = base64_decode($id);
		$data = Individual::where('id', $indID)->first(); 		 
		return view('html.customer.add-customer',compact("data","indID"));
    }

	public function store_customer(Request $request )
    {
        
	  // echo "<pre>"; print_r($request->all()); exit;
				 
        $userId = Auth::id();	
		$obj = new Customer;

        $obj->individual_id  		= $request->individual_id;		
		//$obj->name  			    = $request->name;
		$obj->customer_from  	    = $request->customer_from;
		$obj->customer_to  		    = $request->customer_to;
		$obj->created_by  			= $userId;
		$obj->modified_by  			= $userId; 
		
		$obj->status  				= 1;
		$obj->created  				= date("Y-m-d H:i:s");
		$obj->modified  			= date("Y-m-d H:i:s");
		$is_saved 					= $obj->save();
		if($is_saved)
		{
			Session::put('message', 'Added successfully.');
			Session::put("messageClass","successClass");
			 
            return redirect("/show-customers/".base64_encode($obj->individual_id));
		}

    }
	


	public function update_customer(Request $request)
    {
		
	//  echo "<pre>"; print_r($request->all()); exit;
			 
		$obj = Customer::where('id','=', $request->id)->first();
       
       $userId = Auth::id();	
      	 
		
	//	$obj->name  				= $request->name;
		$obj->customer_from  	    = $request->customer_from;
		$obj->customer_to  			= $request->customer_to;
		$obj->created_by  			= $userId;
		$obj->modified_by  			= $userId;
		$obj->status  				= 1;
		$obj->created  				= date("Y-m-d H:i:s");
		$obj->modified  			= date("Y-m-d H:i:s");
		$is_saved 					= $obj->save();

		if($is_saved)
		{
			Session::put('message', 'Updated successfully.');
			Session::put("messageClass","successClass");
			return redirect("/show-customers/".base64_encode($request->individual_id));
		}

    }

    public function deleteCustomer(Request $request)
    {
		$FId 	= $request->FId;
		$obj 	= Customer::find($FId);
		$obj->status  = '0';
		$obj->save();
		return $FId;
    }



    public function destroy($id)
    {
        //
    }
}

    
    