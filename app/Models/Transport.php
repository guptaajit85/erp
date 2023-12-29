<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transport extends Model
{
    use HasFactory;
    protected $table   = 'transports';   
	public $timestamps = false;
    public function transPortAllotmentDetailsFrom()
  {
    return $this->belongsTo(TransportAllotment::class,'from_station','id');
  }
  public function transPortAllotmentDetailsTo()
  {
    return $this->belongsTo(TransportAllotment::class,'to_station','id');
  }
}

 