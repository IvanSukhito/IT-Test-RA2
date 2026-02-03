<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    //
    protected $table = 'transactions';
    protected $fillable = [
        'ewallet_sender_id',
        'ewallet_receiver_id',
        'trx_code',
        'amount',
        'direction',
        'status',
    ];

}
