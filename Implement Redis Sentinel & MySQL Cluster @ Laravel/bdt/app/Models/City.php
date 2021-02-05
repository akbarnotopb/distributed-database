<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    //
    public function Province(){
      return $this->belongsTo(Province::class,'province_id','id');
    }
}
