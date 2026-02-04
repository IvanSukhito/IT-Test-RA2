<?php

namespace App\Models;

use App\Models\Ewallet;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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

    /**
     * Get the user that owns the Transaction
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function ewalletSender(): BelongsTo
    {
        return $this->belongsTo(Ewallet::class, 'ewallet_sender_id', 'id');
    }

    /**
     * Get the user that owns the Transaction
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function ewalletReceiver(): BelongsTo
    {
        return $this->belongsTo(Ewallet::class, 'ewallet_receiver_id', 'id');
    }

}
