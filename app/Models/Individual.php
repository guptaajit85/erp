<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Individual extends Model
{
    use HasFactory;
	protected $table   = 'individuals';
    // protected $primaryKey = 'individual_id';
	public $timestamps = false;

	public function IndividualBillingAddress()
    {
        return $this->hasmany(IndividualAddress::class,'individual_id','id')->where('address_type','=' ,'b');;
    }


	public function IndividualShipingAddress()
    {
        return $this->hasmany(IndividualAddress::class,'individual_id','id')->where('address_type','=' ,'b');;
    }
    public  function User()
    {
       return $this->hasOne(User::class, 'individual_id','id');
    }

}
