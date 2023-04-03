<?php

namespace App\Models\Wallet;

use App\Models\Traits\Filterable;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Wallet extends Model {

    use HasFactory, Filterable;


    protected $table         = 'wallets';

    protected $primaryKey    = 'wallet_id';

    protected $keyType       = 'int';

    public    $incrementing  = true;

    public    $timestamps    = true;


    /**
     * @return BelongsTo
     */
    public function currency(): BelongsTo
    {
        return $this->belongsTo(WalletCurrency::class, 'currency_id', 'currency_id');
    }

    /**
     * @return BelongsTo
     */
    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id', 'id');
    }

    /**
     * @return HasMany
     */
    public function payments(): HasMany
    {
        return $this->hasMany(WalletPayment::class, 'wallet_id', 'wallet_id');
    }


    protected $with = [
        'currency',
        'owner',
        'payments',
    ];

    protected $casts = [
        'created_at' => 'timestamp',
        'updated_at' => 'timestamp',
    ];

    protected $fillable = [
        'wallet_id', 'currency_id', 'owner_id', 'title', 'note', 'amount', 'status', 'created_at', 'updated_at',
    ];

    protected $hidden = [];
}
