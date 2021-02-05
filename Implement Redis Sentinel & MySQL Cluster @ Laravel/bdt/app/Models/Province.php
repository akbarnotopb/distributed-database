<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    //
    public $table= "provinces";

    public function City(){
    	return $this->hasMany(City::class);
    }
}
