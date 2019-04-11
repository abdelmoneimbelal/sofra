<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Op extends Model 
{

    protected $table = 'order_product';
    public $timestamps = true;
    protected $fillable = array('order_id', 'price', 'quantity', 'apecial_order');

}