<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleOrderItem extends Model
{
    use HasFactory;
    protected $table   = 'sale_order_items';
	public $timestamps = false;
	
	
	 
	 
	public function SaleOrder()
	{
		return $this->belongsTo(SaleOrder::class, 'sale_order_id', 'sale_order_id');
	}
 
	public function WorkOrderItem()
	{
		return $this->hasOne(WorkOrderItem::class, 'sale_order_item_id', 'sale_order_item_id');
	}
	
}
