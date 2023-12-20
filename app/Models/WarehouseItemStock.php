<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WarehouseItemStock extends Model
{ 
	use HasFactory;
	protected $table   = 'warehouse_item_stocks';
	public $timestamps = false;	
	
	public function Item(){
		return $this->hasOne(Item::class, 'item_id', 'item_id');
	}
	public function WarehouseItem()
    {
        return $this->belongsTo(WarehouseItem::class, 'warehouse_item_id', 'id');
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
