<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{

    protected $fillable = ['business_id','contact_name','contact_phone','contact_email','amount','threshold','serialcode','type','about_invoice','activate'];
    protected $appends = ['payable'];

    public function getPayableAttribute(){
        return $this->attributes['amount'] - $this->attributes['paid'];
    }

    public function business()
    {
        return $this->belongsTo('App\Business');
    }
}
