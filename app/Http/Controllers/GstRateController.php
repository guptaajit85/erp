<?php

namespace App\Http\Controllers;

use App\Models\GstRate;
use App\Http\Requests\StoreGstRateRequest;
use App\Http\Requests\UpdateGstRateRequest;
use Illuminate\Http\Request;
use Session;

class GstRateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
		    $search = $request->search;
            $dataP = GstRate::query()
            ->where([['gst_rate', 'LIKE', "%{$search}%"]])
            ->orderByDesc('gst_rate_id')
            ->paginate(20);
           return view('html.gstrate.show-gstrates',compact("dataP"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreGstRateRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreGstRateRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\GstRate  $gstRate
     * @return \Illuminate\Http\Response
     */
    public function show(GstRate $gstRate)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\GstRate  $gstRate
     * @return \Illuminate\Http\Response
     */
    public function edit(GstRate $gstRate)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateGstRateRequest  $request
     * @param  \App\Models\GstRate  $gstRate
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateGstRateRequest $request, GstRate $gstRate)
    {
        //
    }

    public function deactivateGstRate(Request $request)
    {
		$obj = GstRate::where('gst_rate_id', '=', $request->gst_rate_id)->first();

		 $obj->status  					= 0;
		//$obj->created  				= date("Y-m-d H:i:s");
		$obj->modified  				= date("Y-m-d H:i:s");
		$is_saved 						= $obj->save();

		if($is_saved)
		{
			Session::put('message', 'GST Rate deactivated successfully.');
			Session::put("messageClass","successClass");
			return redirect("/show-gstrates");
		}
    }

   

    public function activateGstRate(Request $request)
    {
		$obj = GstRate::where('gst_rate_id', '=', $request->gst_rate_id)->first();

		 $obj->status  					= 1;
		//$obj->created  				= date("Y-m-d H:i:s");
		$obj->modified  				= date("Y-m-d H:i:s");
		$is_saved 						= $obj->save();

		if($is_saved)
		{
			Session::put('message', 'GST Rate activated successfully.');
			Session::put("messageClass","successClass");
			return redirect("/show-gstrates");
		}

    }





    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\GstRate  $gstRate
     * @return \Illuminate\Http\Response
     */
    public function destroy(GstRate $gstRate)
    {
        //
    }
}
