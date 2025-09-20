<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    //
    protected $fillable = [
        'user_id',
        'amount',
        'currency',
        'tx_hash',
        'status',
    ];

    /**
     * The user who owns this transaction.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
