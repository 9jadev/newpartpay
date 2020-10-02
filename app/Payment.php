<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{

    protected $table = 'payments_of_invoice';
    protected $fillable = ['amount','tran_x' ,'business_id','invoices_id', 'payment_status'];

    public function business()
    {
        return $this->belongsTo('App\Business');
    }

    public function invoice()
    {
        return $this->belongsTo('App\Invoice');
    }
}
