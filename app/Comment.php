<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model 
{

    protected $table = 'comments';
    public $timestamps = true;
    protected $fillable = array('client_id', 'comment', 'rate');

    public function clients()
    {
        return $this->belongsTo('App\Client');
    }

    public function resturants()
    {
        return $this->belongsTo('App\Resturant');
    }

}