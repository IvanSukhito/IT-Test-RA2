<?php

namespace App\Models;

use App\Models\Transaction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Ewallet extends Model
{
    //
    protected $table = 'ewallets';
    protected $fillable = [
        'user_id',
        'ewallet_name',
        'ewallet_balance',
        'ewallet_code',
    ];

    protected $appends = ['rupiah_balance'];

    public function getRupiahBalanceAttribute(){
        return 'Rp.' . number_format($this->attributes['ewallet_balance'],0, ',','.');
    }

    /**
     * Get the user that owns the Ewallet
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get all of the comments for the Ewallet
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function transactionSender(): HasMany
    {
        return $this->hasMany(Transaction::class, 'ewallet_sender_id', 'id');
    }

    /**
     * Get all of the comments for the Ewallet
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function transactionReceiver(): HasMany
    {
        return $this->hasMany(Transaction::class, 'ewallet_receiver_id','id');
    }
}
