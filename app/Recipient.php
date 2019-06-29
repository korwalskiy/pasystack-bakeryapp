<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Recipient extends Model
{
    protected $table = 'recipients';
    public $guarded = ['id'];

    public function customer(){
        return $this->belongsTo('App\Customer');
    }
}
