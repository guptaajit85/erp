<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WarehouseItem extends Model
{
    use HasFactory;
	
	protected $table   = 'warehouse_in_items';
	public $timestamps = false;
	protected $guarded = [];
	
	public function Purchase()
    {
        return $this->belongsTo(Purchase::class, 'purchase_id', 'id');
    }
	
	/*
	public function Purchase(){
		return $this->hasOne(Purchase::class, 'id', 'purchase_id');
	}
	*/
	public function Warehouse(){
		return $this->hasOne(Warehouse::class, 'id', 'warehouse_id');
	}
	
	public function WarehouseCompartment(){
		return $this->hasOne(WarehouseCompartment::class, 'id', 'ware_comp_id');
	}
	public function User(){
		return $this->hasOne(User::class, 'id', 'receiver_id');
	}
	
	public function Individual(){
		return $this->hasOne(Individual::class, 'id', 'ind_emp_id');
	} 

	public function ItemType()
    {
        return $this->hasOne(ItemType::class,'item_type_id','item_type_id');
    }
	public function UnitType()
    {
        return $this->hasOne(UnitType::class,'unit_type_id','unit_type_id');
    }
	
	
	
	
	
	
}
