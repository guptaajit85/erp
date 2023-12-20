<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IndividualAddress extends Model
{
    use HasFactory;
    protected $primaryKey = 'ind_add_id';
    protected $table   = 'individual_address';
	public $timestamps = false;

    public function statedetail(){
		return $this->hasOne(State::class, 'id', 'state_id');
	}
    public function indidetail(){
		return $this->hasOne(Individual::class, 'id', 'individual_id');
	}
}
