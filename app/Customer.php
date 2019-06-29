<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $table = "customers";
    public $guarded = ['id'];

    public function recipient(){
        return $this->hasOne('App\Recipient');
    }
}
