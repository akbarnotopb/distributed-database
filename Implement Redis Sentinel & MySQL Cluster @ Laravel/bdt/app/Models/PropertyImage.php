<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PropertyImage extends Model
{
    protected $fillable = ['id', 'name', 'property_id','tumbnail'];

    public function property()
    {
    	return $this->belongTo(Property::class);
    }
}
