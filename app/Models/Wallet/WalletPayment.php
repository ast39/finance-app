<?php

namespace App\Models\Wallet;

use App\Models\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WalletPayment extends Model {

    use HasFactory, Filterable;


    protected $table         = 'wallet_payments';

    protected $primaryKey    = 'payment_id';

    protected $keyType       = 'int';

    public    $incrementing  = true;

    public    $timestamps    = true;


    /**
     * @return BelongsTo
     */
    public function wallet(): BelongsTo
    {
        return $this->belongsTo(Wallet::class, 'wallet_id', 'wallet_id')
            ->without('payments');
    }


    protected $with = [
        'wallet'
    ];

    protected $casts = [
        'created_at' => 'timestamp',
        'updated_at' => 'timestamp',
    ];

    protected $fillable = [
        'payment_id', 'wallet_id', 'amount', 'note', 'status', 'created_at', 'updated_at',
    ];

    protected $hidden = [];
}
