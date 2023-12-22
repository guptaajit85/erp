<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleEntry extends Model
{
    use HasFactory;
    protected $table   = 'sale_entries';
	public $timestamps = false;
    protected $primaryKey = 'sale_entry_id';
	protected $guarded = [];

    
	/*public function SaleEntryItem(){
		return $this->hasOne(SaleEntryItem::class, 'sale_entry_id ', 'sale_order_id');
	}
	*/
	public function SaleEntryItem()
    {
        return $this->hasMany(SaleEntryItem::class, 'sale_entry_id', 'sale_entry_id'); // Replace 'foreign_key' and 'local_key' with your actual keys
    }
	
	public function ItemType(){
		return $this->hasOne(ItemType::class, 'item_type_id', 'sale_order_type');
	}
	
	public function Individual(){
		return $this->hasOne(Individual::class, 'id', 'individual_id');
	}
	


}
