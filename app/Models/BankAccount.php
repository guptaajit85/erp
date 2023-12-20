<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankAccount extends Model
{
    use HasFactory;
    protected $table   = 'bank_accounts';
	public $timestamps = false;
  
	public function bankdetail(){
		return $this->hasOne(Bank::class, 'id', 'bank_id');
	}
	
	 
}
