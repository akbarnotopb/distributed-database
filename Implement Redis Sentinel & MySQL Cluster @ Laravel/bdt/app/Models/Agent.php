<?php

namespace App\Models;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;
use App\Notifications\AgentForgotPasswordNotification;
class Agent extends Authenticatable
{
    use Notifiable;
    protected $guard = 'agents';

  	protected $fillable = [
	    'name', 'email','upline','phone_number', 'password', 'id', 'plain_text_password', 'approved', 'address', 'nik', 'bank_account', 'bank_name', 'bank_customer', 'photo','username','whatsapp'
  	];

  	protected $hidden  =  ['plain_text_password', 'password'];

  	public function isNeededToCompleteData()
  	{
    	return !(@$this->nik && @$this->phone_number && !is_null(@$this->upline) && @$this->username);
  	}

  	public function isApprovedAgent()
  	{
  		return !(@$this->approved==1);
  	}


    public function Uplinenya(){
      return $this->belongsTo(Agent::class, 'upline','id');
    }

    public function Transaction(){
      return $this->hasMany(Transaction::class);
    }


    public function getPhotoAttribute($value)
    {
      return $value ?: "/assets/img/user-placeholder.png";
    }

    public function downline(){
      return $this->hasMany(Downline::class,'upline','id');
    }

    public function sendPasswordResetNotification($token){
      $this->notify(new AgentForgotPasswordNotification($token));
    }
}
