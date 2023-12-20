<?php

namespace App\Http\Controllers;
use Validator, Session,Auth, Hash;
use App\Models\AccountGroup;
use Illuminate\Http\Request;
use App\Http\Controllers\CommonController;

class AccountGroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
         $this->middleware('auth');
}
    public function index(Request $request)
    {
        $search = $request->input('search');


            $dataP = AccountGroup::query()
            ->where([['accountgroup_name', 'LIKE', "%{$search}%"],['status', '=', '1']])
            ->orWhere([['parent_id', 'LIKE', "%{$search}%"],['status', '=', '1']])
            ->orderByDesc('id')
            ->paginate(20);
            return view('html.accountgroup.show-accountgroups',compact("dataP"));

       }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create_accountgroup()
    {
        return view('html.accountgroup.add-accountgroup');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store_accountgroup(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "accountgroup_name"=>"required|string|max:100",
            "parent_id"=>"required|regex:/^[0-9]{1,4}$/",
          ], [
            "accountgroup_name.required"=>"Please enter Account Group name",
            "parent_id.required"=>"Please enter parent id",
          ]);

            if ($validator->fails())
            {
                $error = $validator->errors()->first();
                Session::put('message', $validator->messages()->first());
                Session::put("messageClass","errorClass");
                return redirect()->back()->withInput();
            }
            // $is_saved = Department::create_data($request);
            $obj 	= new AccountGroup();
            $obj->accountgroup_name  					= $request->accountgroup_name;
            $obj->parent_id  					= $request->parent_id;

            // $obj->status  					= 1;
            $obj->created  					= date("Y-m-d H:i:s");
            $obj->modified  				= date("Y-m-d H:i:s");
            $is_saved 						= $obj->save();
            ////////////////////////// Notification Start Added/////////////////////////////
            $userId = Auth::id();
            $modeName = 'AccountGroup';
            $urlPage = $_SERVER['HTTP_REFERER'];
            $mesg = CommonController::getUserName($userId) .' Added Account Group '. $request->accountgroup_name ;
            $pageName = 'add-accountgroup';
            CommonController::store_notification($userId,$modeName,$urlPage,$mesg,$pageName);
            ////////

            if($is_saved)
            {
                Session::put('message', 'Updated successfully.');
                Session::put("messageClass","successClass");
                return redirect("/show-accountgroups");
            }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AccountGroup  $accountGroup
     * @return \Illuminate\Http\Response
     */
    public function show(AccountGroup $accountGroup)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\AccountGroup  $accountGroup
     * @return \Illuminate\Http\Response
     */
    public function edit_accountgroup($id)
    {
        {
            $id = base64_decode($id);
            $data = AccountGroup::where('id', $id)->first();

            $dataP = AccountGroup::where('status', '!=', '0')->orderByDesc('id')->get();
            return view('html.accountgroup.edit-accountgroup',compact("data","dataP"));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\AccountGroup  $accountGroup
     * @return \Illuminate\Http\Response
     */
    public function update_accountgroup(Request $request, AccountGroup $accountGroup)
    {
        $validator = Validator::make($request->all(), [
            "accountgroup_name"=>"required|string|max:100",
            "parent_id"=>"required|regex:/^[0-9]{1,4}$/",
          ], [
            "accountgroup_name.required"=>"Please enter accountgroup name",
            "parent_id.required"=>"Please enter parent id",
          ]);
          if ($validator->fails())
          {
              $error = $validator->errors()->first();
              Session::put('message', $validator->messages()->first());
              Session::put("messageClass","errorClass");
              return redirect()->back()->withInput();
          }
      $obj = AccountGroup::where('id','=', $request->id)->first();

		$obj->accountgroup_name  					= $request->accountgroup_name;
		$obj->parent_id  					= $request->parent_id;

		// $obj->status  					= 1;
		$obj->created  					= date("Y-m-d H:i:s");
		$obj->modified  				= date("Y-m-d H:i:s");
		$is_saved 						= $obj->save();

        ////////////////////////// Notification Start Added/////////////////////////////
        $userId = Auth::id();
        $modeName = 'AccountGroup';
        $urlPage = $_SERVER['HTTP_REFERER'];
        $mesg = CommonController::getUserName($userId) .' Updated Bank Account '. $request->accountgroup_name ;
        $pageName = 'edit-accountgroup';
        CommonController::store_notification($userId,$modeName,$urlPage,$mesg,$pageName);
        ////////

		if($is_saved)
		{
			Session::put('message', 'Updated successfully.');
			Session::put("messageClass","successClass");
			return redirect("/show-accountgroups");
		}
    }
    public function deleteAccountGroup(Request $request)
    {
		$FId 	= $request->FId;
		$obj 	= AccountGroup::find($FId);
		$obj->status  = '0';
		$obj->save();
		////////////////////////// Notification Start Added/////////////////////////////
		$userId = Auth::id();
		$modeName = 'AccountGroup';
		$urlPage = $_SERVER['HTTP_REFERER'];
		$mesg = CommonController::getUserName($userId) .' Deleted Account Group '. $obj->accountgroup_name ;
		$pageName = 'show-accountgroups';
		CommonController::store_notification($userId,$modeName,$urlPage,$mesg,$pageName);
		////////
		return $FId;
    }
     
    public function destroy(AccountGroup $accountGroup)
    {
        //
    }
}
