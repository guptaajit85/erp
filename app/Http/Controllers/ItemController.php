<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Item;
use App\Models\ItemType;
use App\Models\UnitType;
use App\Models\WarehouseItemStock;
use App\Models\ItemYarnRequirement;
use App\Models\ProcessItem;
use App\Models\GstRate;
use App\Exports\ItemExport;

use Excel;
use Validator, Auth, Session, Hash;


class ItemController extends Controller
{
	public function __construct()
    {
         $this->middleware('auth');
    }
	
	public function export()
	{
		return Excel::download(new ItemExport, 'items.xlsx');
	} 
	
	public function index(Request $request)
	{
		$qsearch = trim($request->qsearch);
		$item_type_id = $request->item_type_id;
		$unit_type_id =  $request->unit_type_id;
		$dataI = Item::where(DB::raw("concat(item_name, hsncode, internal_item_name, item_code)"), 'LIKE', '%' . $qsearch . '%')
			->where('item_type_id', 'like', '%' . $item_type_id . '%')
			->where('status', '=', '1')
			->orderByDesc('item_id')
			->paginate(20);

		// Append the query parameters to the pagination links
		$dataI->appends(['qsearch' => $qsearch, 'item_type_id' => $item_type_id]);
		
		$dataIT = ItemType::where('status', '=', '1')->get();
		$dataUT = UnitType::where('status', '=', '1')->orderByDesc('unit_type_id')->get();
		return view('html.item.show-items',compact("dataI","qsearch","dataIT","item_type_id","dataUT","unit_type_id"));
	}
		
	

	public function showItemList(Request $request)
    {
		// echo "<pre>"; print_r($request->all()); exit;
		$ItemTypeId = $request->ItemTypeId;
		$dataIT = ItemType::where('item_type_id', '=', $ItemTypeId)->where('status', '=', '1')->first();
		$dataI = WarehouseItemStock::select('*')
		->where('item_type_id', '=', $ItemTypeId)
		->where('status', '=', 1)
		->groupBy('item_id')
		->get();

		$str ="<table class='table table-bordered'>
		<tr>
			<th>Item</th>
			<th>Quantity</th>
		</tr>";
		foreach($dataI as $row)
		{
			$itemId = $row->item_id;
			$qty 				= CommonController::getTotalAvalableStockItem($itemId,$ItemTypeId);
			$ItemName 			= DB::table('items')->where('item_id', $row->item_id)->value('item_name');
			$str .="<tr><td>  ".$ItemName."</td>
			<td>".$qty['0']."</td><td>".$qty['1']."</td></tr>";
		}
		$str .="</table>";

		$result = [];
		$result['ItemTypeName'] 		= $dataIT->item_type_name;
		$result['RequestedItemList']  	= $str;
		echo json_encode($result);


    }


    public function edit($id)
    {
		$id 	= base64_decode($id);
		$data   = Item::where('item_id', $id)->first();
		$dataIT = ItemType::where('status', '=', '1')->orderByDesc('item_type_id')->get();
		$dataUT = UnitType::where('status', '=', '1')->orderByDesc('unit_type_id')->get();
		$IgstAr = config('global.IGST_RATES');
		$CgstAr = config('global.CGST_RATES');
		$SgstAr = config('global.SGST_RATES');

		return view('html.item.edit-item',compact("data","dataIT","dataUT",'IgstAr', 'CgstAr','SgstAr'));
    }


	public function create()
    {
		$dataIT = ItemType::where('status', '=', '1')->get();
		$dataGst = GstRate::where('status', '=', '1')->get();
		$dataUT = UnitType::where('status', '=', '1')->orderByDesc('unit_type_id')->get();
		//echo '<pre>';print_r($dataGst);die;

		$IgstAr = config('global.IGST_RATES');
		$CgstAr = config('global.CGST_RATES');
		$SgstAr = config('global.SGST_RATES');

		return view('html.item.add-item', compact("dataIT","dataUT",'IgstAr', 'CgstAr','SgstAr'));
    }
 
 
    public function store(Request $request)
    {
		// echo "<pre>"; print_r($request->all()); exit;
		$validator = Validator::make($request->all(), [
            "item_name"=>"required",
            "pur_rate"=>"required",
            "igst"=>"required",
          ], [
            "item_name.required"=>"Please enter name.",
            "pur_rate.required"=>"Please enter purchase rate.",
            "igst.required"=>"Please enter igst rate.",
          ]);

		if ($validator->fails())
		{
			$error = $validator->errors()->first();
			Session::put('message', $validator->messages()->first());
			Session::put("messageClass","errorClass");
			return redirect()->back()->withInput();
		}
		
		$userId = Auth::id();
		$obj = new Item;
		$obj->item_name  					= $request->item_name;
		if(!empty($request->item_code))$obj->item_code  					= $request->item_code;
		else $obj->item_code  				= '0';
		$obj->internal_item_name  			= $request->internal_item_name;
		$obj->unit_price  					= $request->unit_price;
		if(!empty($request->hsncode))$obj->hsncode  						= $request->hsncode;
		else $obj->hsncode  				= '0';
		$obj->item_type_id  				= $request->item_type_id;
		$obj->unit_type_id  				= $request->unit_type_id;
		$obj->cut  							= $request->cut;
		$obj->igst  						= $request->igst;
		$obj->cgst  						= $request->cgst;
		$obj->sgst  						= $request->sgst;

		$obj->sale_igst  					= $request->sale_igst;
		$obj->sale_cgst  					= $request->sale_cgst;
		$obj->sale_sgst  					= $request->sale_sgst;
		
		$obj->pur_rate  					= $request->pur_rate;
		$obj->sale_rate  					= $request->sale_rate;
		$obj->item_gsm  					= $request->item_gsm;
		$obj->remarks  						= $request->remarks;
		$obj->is_conusmable  				= $request->is_conusmable;
		$obj->created_by  					= $userId;
		$obj->modified_by  					= $userId;
		$obj->status  						= 1;
		$obj->created  						= date("Y-m-d H:i:s");
		$obj->modified  					= date("Y-m-d H:i:s");
		$is_saved 							= $obj->save();
		if($is_saved)
		{
			Session::put('message', 'Added successfully.');
			Session::put("messageClass","successClass");
			return redirect("/show-items");
		}

    }




    public function update(Request $request, Item $item)
    {
		  // echo "<pre>"; print_r($request->all()); exit;
		$validator = Validator::make($request->all(), [
            "item_name"=>"required",
          ], [
            "item_name.required"=>"Please enter name.",
          ]);
		if ($validator->fails())
		{
			$error = $validator->errors()->first();
			Session::put('message', $validator->messages()->first());
			Session::put("messageClass","errorClass");
			return redirect()->back()->withInput();
		}


		$obj = Item::find($request->id);
		$userId = Auth::id();

		$obj->item_name  					= $request->item_name;
		$obj->item_code  					= $request->item_code;
		$obj->internal_item_name  			= $request->internal_item_name;
		$obj->unit_price  					= $request->unit_price;
		$obj->hsncode  						= $request->hsncode;
		$obj->item_type_id  				= $request->item_type_id;
		$obj->unit_type_id  				= $request->unit_type_id;
		$obj->cut  							= $request->cut;
		$obj->item_gsm  					= $request->item_gsm;
		$obj->igst  						= $request->igst;
		$obj->cgst  						= $request->cgst;
		$obj->sgst  						= $request->sgst;
		$obj->pur_rate  					= $request->pur_rate;
		$obj->sale_rate  					= $request->sale_rate;
		$obj->remarks  						= $request->remarks;
		$obj->is_conusmable  				= $request->is_conusmable;
		$obj->created_by  					= $userId;
		$obj->modified_by  					= $userId;
		$obj->status  						= 1;
		$obj->created  						= date("Y-m-d H:i:s");
		$obj->modified  					= date("Y-m-d H:i:s");
		$is_saved 							= $obj->save();
		if($is_saved)
		{
			Session::put('message', 'Updated successfully.');
			Session::put("messageClass","successClass");
			return redirect("/show-items");
		}
    }

	// below function added by Dineshon 04-09-2023
	public function manage_yarn($id)
    {

        $id 	= base64_decode($id);
		$data   = Item::where('item_id', $id)->first();
		$dataI 	= Item::where('status', '=', '1')->where('item_type_id', '=', '1')->get();
		$dataP = ProcessItem::whereIn('id', [1,2])->where('status', '=', '1')->get();
        $reedPkAr = config('global.reedPkAr');

		//$dataIYR = ItemYarnRequirement::where('status', '=', '1')->where('item_id', '=', $id)->orderByDesc('iyr_id')->get();
        $dataIYR = ItemYarnRequirement::where('status', '=', '1')->where('item_id', '=', $id)->get();
      //echo '<pre>';print_r($reedPkAr);die;

		return view('html.item.manage-yarn',compact('data', 'dataIYR','dataI','dataP','reedPkAr'));
    }

    public function add_manage_yarn(Request $request)
	{
		// echo "<pre>"; print_r($request->all()); exit;
		$validator = Validator::make($request->all(), [
            "item_id"=>"required",
            "yarn_id"=>"required",
          ], [
            "item_id.required"=>"Please select Item.",
            "yarn_id.required"=>"Please select Yarn.",
          ]);
		if ($validator->fails())
		{
			$error = $validator->errors()->first();
			Session::put('message', $validator->messages()->first());
			Session::put("messageClass","errorClass");
			return redirect()->back()->withInput();
		}
		
        $itemid 	= $request->item_id;
        $yarnArr 	= $request->yarn_id;
		$process_arr     = $request->process_id;
		$qty_arr 		= $request->yarn_quantity;
		$reed_peak_arr 		= $request->reed_peak;

        $curDate 		= date("Y-m-d");
        $unit  = 'Kg';
       // echo '<pre>'; print_r($request->all());exit;
        foreach($yarnArr as $itemidk=>$valArr)
		{

            $yarn_id 	= $yarnArr[$itemidk];
            $process_id 		= $process_arr[$itemidk];
            $qty 		= $qty_arr[$itemidk];
            $reed_peak 		= $reed_peak_arr[$itemidk];

            $data[] = array(

                'item_id' => $itemid,
                'process_id' => $process_id,
                'yarn_id' => $yarn_id,
                'reed_peak' => $reed_peak,
                'yarn_quantity' => $qty,
                'unit' => $unit,
                'status' => 1,
                'created' => date("Y-m-d"),
                'modified' => date("Y-m-d")
            );

		}

		$res =  ItemYarnRequirement::insert($data);

        if($res)
		{
			$itemid = base64_encode($itemid);
			Session::put('message', 'Data Added successfully.');
			Session::put("messageClass","successClass");
			return redirect("/manage-yarn/".$itemid);
		}



    }

	public function deleteItem(Request $request)
    {
		$FId 	= $request->FId;
		$obj 	= Item::find($FId);
		$obj->status  = '0';
		$obj->save();
		return $FId;
    }
    public function deleteYarn(Request $request)
    {
		$FId 	= $request->FId;
		$obj 	= ItemYarnRequirement::find($FId);
		$obj->status  = '0';
		$obj->save();
		return $FId;
    }

	public function get_item_data()
    {
        return Excel::download(new Item, 'item.xlsx');
    }








}
