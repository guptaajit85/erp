<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Models\Agent;
use App\Models\Person;
use App\Models\Individual;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;
use Validator, Session, Hash;


class AgentController extends Controller
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
		$dataP = Agent::where('status', '=', '1')->paginate(20);
		// echo "<pre>";  print_r($dataI); exit;
		return view('html.agent.show-agents',compact("dataP","qsearch","dataI"));
    }

    public function edit_agent ($id)
	{
		$id = base64_decode($id);
		$data = Agent::where('id', $id)->first();
		$indID = $data->individual_id;
        $dataI = Individual::where('id', $indID)->first();
		return view('html.agent.edit-agent',compact("data","dataI"));
	}

    public function create_agent($id)
    {
		$indID = base64_decode($id);
		$data = Individual::where('id', $indID)->first();
		return view('html.agent.add-agent',compact("data","indID"));
    }

	public function store_agent(Request $request )
    {

	  // echo "<pre>"; print_r($request->all()); exit;

        $userId = Auth::id();
		$obj = new Agent;

        $obj->individual_id  		= $request->individual_id;
		//$obj->name  			    = $request->name;
		$obj->agent_from  		    = $request->agent_from;
		$obj->agent_to  		    = $request->agent_to;
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

            return redirect("/show-agents/".base64_encode($obj->individual_id));
		}

    }



	public function update_agent(Request $request)
    {

	//  echo "<pre>"; print_r($request->all()); exit;

		$obj = Agent::where('id','=', $request->id)->first();

       $userId = Auth::id();


	//	$obj->name  				= $request->name;
		$obj->agent_from  			= $request->agent_from;
		$obj->agent_to  			= $request->agent_to;
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
			return redirect("/show-agents/".base64_encode($request->individual_id));
		}

    }

    public function deleteAgent(Request $request)
    {
		$FId 	= $request->FId;
		$obj 	= Agent::find($FId);
		$obj->status  = '0';
		$obj->save();
		return $FId;
    }



    public function destroy($id)
    {
        //
    }
}

