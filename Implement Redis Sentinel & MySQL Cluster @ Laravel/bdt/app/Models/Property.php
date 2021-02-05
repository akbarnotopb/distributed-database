<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    protected $fillable = [
        'name', 'price', 'address', 'agent_id', 'id', 'agent_type', 'listing_type', 'property_type_id', 'land_size', 'built_up', 'description', 'area', 'bedrooms', 'bathrooms', 'beds', 'garages', 'city_id', 'subdistrict_id', 'approved', 'sold', 'maid_bedrooms', 'maid_bathrooms', 'certificate', 'year_built', 'electrical_power', 'number_of_floors', 'amount_of_down_payment', 'estimated_installments', 'complete_address', 'floor_number',
        'parking_amount', 'owner_name', 'owner_phone', 'colisting'
    ];

    protected $appends = ['city_name', 'agent_name', 'image', 'created_at_for_human', 'detail_url', 'property_type_name'];

    public function PropertyImages()
    {
        return $this->hasMany(PropertyImage::class);
    }

    public function PropertyType()
    {
        return $this->belongsTo(PropertyType::class, 'property_type_id');
    }

    public function getCityNameAttribute()
    {
        return (City::find($this->city_id)->name);
    }

    public function Agent()
    {
        return $this->agent_type == "admin" ? $this->belongsTo(\App\User::class, 'agent_id') : $this->belongsTo(Agent::class);
    }

    public function getAgentNameAttribute()
    {
        return $this->agent_type == "agent" ? Agent::find($this->agent_id)->name : "Admin";
    }

    public function getImageAttribute()
    {
        $images = PropertyImage::where('property_id', $this->id)->first();
        return $images ? ((!is_null($images->tumbnail)) ? asset($images->tumbnail) : asset($images->name)) : url('assets/frontend/media-demo/properties/554x360/02.jpg');
    }

    public function getCreatedAtForHumanAttribute()
    {
        return $this->created_at->diffForHumans();
    }

    public function getDetailUrlAttribute()
    {
        return route('listing.property.show', [$this->id]);
    }

    public function City()
    {
        return $this->belongsTo(City::class);
    }

    public function Subdistrict()
    {
        return $this->belongsTo(Subdistrict::class);
    }

    public function Favorite()
    {
        return $this->hasMany(Favorite::class);
    }

    public function Transaction()
    {
        return $this->belongsTo(Transaction::class);
    }

    public function getPropertyTypeNameAttribute()
    {
        return PropertyType::find($this->property_type_id)->name;
    }
}
