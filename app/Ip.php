<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ip extends Model 
{

    protected $table = 'item_resturant';
    public $timestamps = true;
    protected $fillable = array('item_id', 'resturant_id');

}