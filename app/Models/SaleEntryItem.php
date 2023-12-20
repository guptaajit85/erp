<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleEntryItem extends Model
{
    use HasFactory;
    protected $table   = 'sale_entry_items';
	public $timestamps = false;
}
