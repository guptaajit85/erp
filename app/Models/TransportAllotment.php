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
}
