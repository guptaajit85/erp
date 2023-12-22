<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleOrder extends Model
{
    use HasFactory;
    protected $table   = 'sale_orders';
	public $timestamps = false;
    protected $primaryKey = 'sale_order_id';
	
	
	public function ItemType(){
		return $this->hasOne(ItemType::class, 'item_type_id', 'sale_order_type');
	}
	
	public function Individual(){
		return $this->hasOne(Individual::class, 'id', 'individual_id');
	}
	
	 
 
		 
	public function SaleOrderItem()
	{
		return $this->hasMany(SaleOrderItem::class, 'sale_order_id', 'sale_order_id');
	}
	 
 
	public function WorkOrder()
    {
        return $this->hasMany(WorkOrder::class, 'sale_order_id', 'sale_order_id');
    }
	
	 
	 
}
