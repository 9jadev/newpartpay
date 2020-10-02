<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Business extends Model
{
    
    protected $fillable = ['business_name', 'user_id', 'business_type', 'business_about', 'account_total', 'bank_name', 'bank_code', 'account_number'];
    
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function contacts()
    {
        return $this->hasMany('App\Contact');
    }

    public function invoices()
    {
        return $this->hasMany('App\Invoice');
    }
    public function payments(){
        return $this->hasMany('App\Payment');
    }
}
