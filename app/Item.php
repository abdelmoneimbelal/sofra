<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model 
{

    protected $table = 'items';
    public $timestamps = true;
    protected $fillable = array('name');

    public function products()
    {
        return $this->hasMany('App\Client');
    }

    public function resturants()
    {
        return $this->belongsToMany('App\Resturant');
    }

}