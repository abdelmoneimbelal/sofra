<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model 
{

    protected $table = 'orders';
    public $timestamps = true;
    protected $fillable = array('title', 'description', 'rate', 'status', 'less_order', 'delivery_value', 'resturant_id', 'city_id', 'client_id', 'payment_method_id', 'notification_id');

    public function clients()
    {
        return $this->belongsTo('App\Client');
    }

    public function resturants()
    {
        return $this->belongsTo('App\Resturant');
    }

    public function notifications()
    {
        return $this->belongsTo('App\Notification');
    }

    public function payment_methods()
    {
        return $this->belongsTo('App\Payment_method');
    }

    public function Order_Product()
    {
        return $this->belongsToMany('App\Products');
    }

}