<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Resturant extends Model
{

    protected $table = 'resturants';
    public $timestamps = true;
    protected $fillable = array('name', 'region_id', 'password', 'email', 'status', 'image', 'less_order', 'delivery_value', 'phone', 'whatsapp', 'api_token', 'pin_code');

    public function orders()
    {
        return $this->hasMany('App\Order');
    }

    public function comments()
    {
        return $this->hasMany('Comment');
    }

    public function products()
    {
        return $this->hasMany('Product');
    }

    public function offers()
    {
        return $this->hasMany('Offer');
    }

    public function items()
    {
        return $this->belongsToMany('App\Item');
    }

    public function regions()
    {
        return $this->belongsTo('App\Region');
    }

    public function tokens()
    {
        return $this->morphMany('App\Token', 'accountable');
    }

    protected $hidden = [
        'password', 'api_token'
    ];

}
