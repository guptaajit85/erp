<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkProcessRequirement extends Model
{ 
	use HasFactory;
	protected $table   = 'work_process_requirements';
	public $timestamps = false;
	
	
	
	public function Item(){
		return $this->hasOne(Item::class, 'item_id', 'item_id');
	}
	
	public function WorkOrder()
	{
		return $this->hasOne(WorkOrder::class, 'work_order_id', 'work_order_id');
	}
	
	public function WarehouseItemStock(){
		return $this->hasMany(WarehouseItemStock::class, 'item_id', 'item_id')->where('is_allotted_stock', '=', 'No');
	}
	
	
	
	
}
