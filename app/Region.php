<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Region extends Model 
{

    protected $table = 'regions';
    public $timestamps = true;
    protected $fillable = array('name', 'city_id');

    public function clients()
    {
        return $this->hasMany('App\Client');
    }

    public function resturants()
    {
        return $this->hasMany('App\Resturant');
    }

    public function cities()
    {
        return $this->belongsTo('App\City');
    }

}