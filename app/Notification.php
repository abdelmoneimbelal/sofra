<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model 
{

    protected $table = 'notifications';
    public $timestamps = true;
    protected $fillable = array('title', 'content', 'notifiable_type', 'notifiable_id');

    public function notifiable()
    {
        return $this->morphTo();
    }

    public function orders()
    {
        return $this->hasOne('App\Order');
    }

}