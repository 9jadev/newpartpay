<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $fillable = ['business_id','name','phone','email'];

    public function business()
    {
        return $this->belongsTo('App\Business');
    }
}
