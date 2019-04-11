<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Token extends Model
{
    protected $table = 'tokens';
    public $timestamps = true;
    protected $fillable = array('accountable_id','token','type', 'accountable_type');

    public function accountable()
    {
        return $this->morphTo();
    }
    
}


