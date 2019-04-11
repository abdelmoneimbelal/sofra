<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model 
{

    protected $table = 'clients';
    public $timestamps = true;
    protected $fillable = array('name', 'email', 'phone', 'image', 'description', 'password', 'city_id', 'region_id', 'api_token', 'pin_code');

    public function notifications()
    {
        return $this->morphMany('App\Notification', 'notifiable');
    }

    public function orders()
    {
        return $this->hasMany('App\Order');
    }

    public function comments()
    {
        return $this->hasMany('App\Comment');
    }

    public function products()
    {
        return $this->hasMany('App\Product');
    }
     public function contacts()
    {
        return $this->hasMany('App\Contact');
    }

    public function cities()
    {
        return $this->belongsTo('App\City');
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
