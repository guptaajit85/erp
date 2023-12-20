<?php

namespace App\Http\Controllers;

use App\Models\Chemical;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\CommonController;

use Validator, Session,Auth, Hash;


class ChemicalController extends Controller
{
    public function __construct()
    {
         $this->middleware('auth');
}
    public function index(Request $request)
    {
        $search = $request->input('search');

            $dataP = Chemical::query()
            ->where([['chemical_name', 'LIKE', "%{$search}%"],['status', '=', '1']])
            ->orderByDesc('id')
            ->paginate(2);
            return view('html.chemical.show-chemicals',compact("dataP"));
    }



    public function create_chemical()
    {
        return view('html.chemical.add-chemical');
    }


    public function store_chemical(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "chemical_name"=>"required|string|max:100",

          ], [
            "name.required"=>"Please enter name.",

          ]);

		if ($validator->fails())
		{
			$error = $validator->errors()->first();
			Session::put('message', $validator->messages()->first());
			Session::put("messageClass","errorClass");
			return redirect()->back()->withInput();
		}

	/*	$is_saved = chemical::create_data($request);*/

		$obj = new Chemical;
		$obj->chemical_name  					= $request->chemical_name;
		$obj->created  					= date("Y-m-d H:i:s");
		$obj->modified  				= date("Y-m-d H:i:s");
		$is_saved 						= $obj->save();

        ////////////////////////// Notification Start Added/////////////////////////////
        $userId = Auth::id();
        $modeName = 'Chemical';
        $urlPage = $_SERVER['HTTP_REFERER'];
        $mesg = CommonController::getUserName($userId) .' Added Chemical '. $request->chemical_name ;
        $pageName = 'add-chemical';
        CommonController::store_notification($userId,$modeName,$urlPage,$mesg,$pageName);
        ////////

		if($is_saved)
		{
			Session::put('message', 'Added successfully.');
			Session::put("messageClass","successClass");
			return redirect("/show-chemicals");
		}

    }


    public function show(chemical $chemical)
    {
        //
    }


    public function edit_chemical($id)
    {
        {
            $id = base64_decode($id);
            $data = Chemical::where('id', $id)->first();

            $dataP = Chemical::where('status', '!=', '0')->orderByDesc('id')->get();
            return view('html.chemical.edit-chemical',compact("data","dataP"));
        }
    }


    public function update_chemical(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "chemical_name"=>"required|string|max:100",
          ], [
            "chemical_name.required"=>"Please enter name.",

          ]);
		if ($validator->fails())
		{
			$error = $validator->errors()->first();
			Session::put('message', $validator->messages()->first());
			Session::put("messageClass","errorClass");
			return redirect()->back()->withInput();
		}
		// echo "<pre>"; print_r($request); exit;
		// $is_saved = Person::create_data($request);

		$obj = Chemical::find($request->id);
		$obj->chemical_name  					= $request->chemical_name;

		// $obj->status  					= 1;
		$obj->created  					= date("Y-m-d H:i:s");
		$obj->modified  				= date("Y-m-d H:i:s");
		$is_saved 						= $obj->save();

        ////////////////////////// Notification Start Added/////////////////////////////
        $userId = Auth::id();
        $modeName = 'Chemical';
        $urlPage = $_SERVER['HTTP_REFERER'];
        $mesg = CommonController::getUserName($userId) .' Updated Chemical '. $request->chemical_name ;
        $pageName = 'edit-chemical';
        CommonController::store_notification($userId,$modeName,$urlPage,$mesg,$pageName);
        ////////

		if($is_saved)
		{
			Session::put('message', 'Updated successfully.');
			Session::put("messageClass","successClass");
			return redirect("/show-chemicals");
		}

    }
    public function deleteChemical(Request $request)
    {
		$FId 	= $request->FId;
		$obj 	= Chemical::find($FId);
		$obj->status  = '0';
		$obj->save();

        ////////////////////////// Notification Start Added/////////////////////////////
        $userId = Auth::id();
        $modeName = 'Chemical';
        $urlPage = $_SERVER['HTTP_REFERER'];
        $mesg = CommonController::getUserName($userId) .' Deleted Chemical '. $obj->chemical_name ;
        $pageName = 'show-chemicals';
        CommonController::store_notification($userId,$modeName,$urlPage,$mesg,$pageName);
        ////////

		return $FId;
    }


    public function destroy(chemical $chemical)
    {
        //
    }

}
