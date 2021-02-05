<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    protected $fillable = ['id','property_id','agent_id'];

    public function Property(){
    	return $this->belongsTo(Property::class,'property_id','id');
    }
}
