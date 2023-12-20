<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemYarnRequirement extends Model
{
    use HasFactory;
    protected $table   		= 'item_yarn_requirements';
    protected $primaryKey 	= 'iyr_id';
	public $timestamps      = false;

    public function getitem()
    {
        return $this->hasOne(Item::class,'item_id','item_id');
    }
    public function getyarn()
    {
        return $this->hasOne(Item::class,'item_id','yarn_id');
    }

    public function getprocess()
    {
        return $this->hasOne(ProcessItem::class,'id','process_id');
    }
}
