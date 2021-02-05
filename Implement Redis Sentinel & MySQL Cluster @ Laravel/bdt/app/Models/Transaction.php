<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    //
    protected $table = 'transaction';

    protected $fillable = ['id', 'agent_id', 'property_id', 'status', 'keterangan'];

    public function Agent()
    {
        return $this->belongsTo(Agent::class, 'agent_id', 'id');
    }
    public function Property()
    {
        return $this->hasMany(Property::class, 'property_id', 'id');
    }
}
