<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;
    protected $table   = 'companies';
	public $timestamps = false;
    public function statedetail(){
		return $this->hasOne(State::class, 'id', 'state_id');
	}
}
