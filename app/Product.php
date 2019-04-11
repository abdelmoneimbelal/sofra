<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model 
{

    protected $table = 'products';
    public $timestamps = true;
    protected $fillable = array('name', 'description', 'price', 'image', 'processing_time', 'client_id', 'resturant_id', 'item_id');

    public function clients()
    {
        return $this->belongsTo('App\Client');
    }

    public function resturants()
    {
        return $this->belongsTo('App\Resturant');
    }

    public function items()
    {
        return $this->belongsTo('App\Item');
    }

    public function Order_Product()
    {
        return $this->belongsToMany('App\Order');
    }

}