<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Offer extends Model 
{

    protected $table = 'offers';
    public $timestamps = true;
    protected $fillable = array('description', 'name', 'price', 'image', 'start_date', 'end_date', 'resturant_id');

    public function resturants()
    {
        return $this->belongsTo('App\Resturant');
    }

}