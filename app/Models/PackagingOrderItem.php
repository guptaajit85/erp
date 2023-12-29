<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PackagingOrderItem extends Model
{
	protected $table = 'packaging_order_items';
	protected $primaryKey = 'id';
	public $timestamps = false;

    public function packagingOrder()
    {
        return $this->belongsTo(PackagingOrder::class, 'packaging_ord_id', 'id');
    }
	
	public function PackagingType()
	{
		return $this->hasOne(PackagingType::class, 'id', 'pack_type');
	}	
	
	public function Item()
	{
		return $this->hasOne(Item::class, 'item_id', 'item_id');
	}
	
	public function saleOrderItem()
    {
        return $this->belongsTo(SaleOrderItem::class, 'sale_order_item_id', 'sale_order_item_id');
    }
	
	 
}
