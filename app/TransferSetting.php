<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TransferSetting extends Model
{
    protected $table = 'transfer_settings';
    public $guarded = ['id'];
}
