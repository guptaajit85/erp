<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;
	protected $table   = 'vehicles';
	public $timestamps = false;

    public  function vehicledetail()
    {
  // $dataP = BankAccount::where('status', '=', '1')->with('bankdetail')->get();

       return $this->hasOne(Brand::class, 'id','brand_id');
    }

}
