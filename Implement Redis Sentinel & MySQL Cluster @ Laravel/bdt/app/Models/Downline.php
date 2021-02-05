<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Downline extends Model
{
	public $table = 'downline';
    protected $fillable = ['id','upline','downline'];

    public function agent(){
    	return $this->belongsTo(Agent::class,'id','upline');
    }
}
