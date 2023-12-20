<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkOrder extends Model
{
    use HasFactory;
    protected $table   		= 'work_orders';
    protected $primaryKey   = 'work_order_id ';
	public $timestamps = false;
	
	
	
	
	public function WorkReqSend()
	{
		return $this->hasOne(Individual::class, 'id', 'work_req_send_by');
	}	
	public function ProcessType()
	{
		return $this->hasOne(ProcessItem::class, 'id', 'process_type_id');
	} 
	
	public function Item()
	{
		return $this->hasOne(Item::class, 'item_id', 'item_id');
	}
	
	public function GatepassGenratedByWarehouseUser()
	{
		return $this->hasOne(Individual::class, 'id', 'gatepass_genrated_by_warehouse_user');
	}
	
	
	public function WarehouseItem()
	{
		return $this->hasOne(WarehouseItem::class, 'process_type_id', 'process_type_id');
	}
	
	
	public function saleOrderItem()
    {
        return $this->belongsTo(SaleOrderItem::class, 'sale_order_item_id', 'sale_order_item_id');
    }
	
	
	public function WorkOrderItem(){
		return $this->hasMany(WorkOrderItem::class, 'work_order_id', 'work_order_id');
	}
	
	public function WorkOrderItemDetail(){
		return $this->hasMany(WorkOrderItemDetail::class, 'work_order_id', 'work_order_id');
	}
	
	
	public function GatePass(){
		return $this->hasMany(GatePass::class, 'work_order_id', 'work_order_id');
	}
	
	public function WorkInspection(){
		return $this->hasMany(WorkInspection::class, 'work_order_id', 'work_order_id');
	}
	
	
	 
	 
	
	
	 
	
	 

}




