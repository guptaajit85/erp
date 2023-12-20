<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkOrderItemDetail extends Model
{
    use HasFactory;
	
	protected $table   		= 'work_order_item_details';
    protected $primaryKey 	= 'woi_id';
	public $timestamps 		= false;
	protected $guarded = [];
	
	public function WorkOrder()
    {
        return $this->belongsTo(WorkOrder::class, 'work_order_id', 'work_order_id');
    }
	
	
}
