<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkOrderItem extends Model
{
    use HasFactory;
	 
	protected $table   		= 'work_order_items';
    protected $primaryKey 	= 'woi_id';
	public $timestamps 		= false;
	
	
	public function WorkOrder()
    {
        return $this->belongsTo(WorkOrder::class, 'work_order_id', 'work_order_id');
    }
	
	
	
}
