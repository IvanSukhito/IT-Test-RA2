<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Ewallet extends Model
{
    //
    protected $table = 'ewallets';
    protected $fillable = [
        'ewallet_name',
        'ewallet_balance',
        'ewallet_code',
    ];


}
