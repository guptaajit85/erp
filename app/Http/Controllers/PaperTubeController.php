<?php

namespace App\Http\Controllers;

use App\Models\PaperTube;
use Illuminate\Http\Request;
use Validator, Session, Hash;
class PaperTubeController extends Controller
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

        $dataP = PaperTube::query()
        ->where([['paperTube_name', 'LIKE', "%{$search}%"],['status', '=', '1']])
        ->orderByDesc('id')
        ->paginate(20);
        return view('html.papertube.show-papertubes',compact("dataP"));
}

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create_papertube()
    {
        return view('html.papertube.add-papertube');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store_papertube(Request $request)
    {
			$validator = Validator::make($request->all(), [
				"paperTube_name"=>"required|max:100",
				"features"=>"required|string|max:100",
				], [
				"paperTube_name.required"=>"Please enter papertube name",
				"features.required"=>"Please enter features",
			]);

			if ($validator->fails())
			{
				$error = $validator->errors()->first();
				Session::put('message', $validator->messages()->first());
				Session::put("messageClass","errorClass");
				return redirect()->back()->withInput();
			}
            // $is_saved = Department::create_data($request);
            $obj 	= new PaperTube;
            $obj->paperTube_name  					= $request->paperTube_name;
            $obj->features  					= $request->features;

            // $obj->status  					= 1;
            $obj->created  					= date("Y-m-d H:i:s");
            $obj->modified  				= date("Y-m-d H:i:s");
            $is_saved 						= $obj->save();

            if($is_saved)
            {
                Session::put('message', 'Updated successfully.');
                Session::put("messageClass","successClass");
                return redirect("/show-papertubes");
            }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PaperTube  $paperTube
     * @return \Illuminate\Http\Response
     */
    public function show(PaperTube $paperTube)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PaperTube  $paperTube
     * @return \Illuminate\Http\Response
     */
    public function edit_papertube($id)
    {
        {
            $id = base64_decode($id);
            $data = PaperTube::where('id', $id)->first();

            $dataP = PaperTube::where('status', '!=', '0')->orderByDesc('id')->get();
            return view('html.papertube.edit-papertube',compact("data","dataP"));
        }
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PaperTube  $paperTube
     * @return \Illuminate\Http\Response
     */
    public function update_papertube(Request $request, PaperTube $paperTube)
    {
        $validator = Validator::make($request->all(), [
            "paperTube_name"=>"required|max:100",
            "features"=>"required|string|max:100",
          ], [
            "paperTube_name.required"=>"Please enter papertube name",
            "features.required"=>"Please enter features",
          ]);
          if ($validator->fails())
          {
              $error = $validator->errors()->first();
              Session::put('message', $validator->messages()->first());
              Session::put("messageClass","errorClass");
              return redirect()->back()->withInput();
          }
      $obj = PaperTube::where('id','=', $request->id)->first();

		$obj->paperTube_name  					= $request->paperTube_name;
		$obj->features  					= $request->features;

		// $obj->status  					= 1;
		$obj->created  					= date("Y-m-d H:i:s");
		$obj->modified  				= date("Y-m-d H:i:s");
		$is_saved 						= $obj->save();

		if($is_saved)
		{
			Session::put('message', 'Updated successfully.');
			Session::put("messageClass","successClass");
			return redirect("/show-papertubes");
		}
    }
    public function deletePaperTube(Request $request)
    {
		$FId 	= $request->FId;
		$obj 	= PaperTube::find($FId);
		$obj->status  = '0';
		$obj->save();
		return $FId;
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PaperTube  $paperTube
     * @return \Illuminate\Http\Response
     */
    public function destroy(PaperTube $paperTube)
    {
        //
    }
}
