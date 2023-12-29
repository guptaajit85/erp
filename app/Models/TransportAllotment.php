<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransportAllotment extends Model
{
    use HasFactory;
	  protected $table   		= 'transport_allotments';
	  public $timestamps 		= false;
    protected $primaryKey 	= 'id';

    public function IndividualDetails()
    {
      return $this->hasOne(Individual::class,'id','packaging_ord_id');
    }  
    public function locationDetailsFrom()
    {
      return $this->hasOne(Transport::class,'id','from_station');
    }
    public function locationDetailsTo()
    {
      return $this->hasOne(Transport::class,'id','to_station');
    }
}
