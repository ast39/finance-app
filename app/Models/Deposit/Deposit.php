<?php

namespace App\Models\Deposit;

use App\Models\Traits\Filterable;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Deposit extends Model {

    use HasFactory, Filterable;


    protected $table         = 'deposits';

    protected $primaryKey    = 'deposit_id';

    protected $keyType       = 'int';

    public    $incrementing  = true;

    public    $timestamps    = true;


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
        return $this->hasMany(DepositPayment::class, 'deposit_id', 'deposit_id');
    }


    protected $with = [
        'owner',
        'payments',
    ];

    protected $casts = [
        'created_at' => 'timestamp',
        'updated_at' => 'timestamp',
    ];

    protected $fillable = [
        'deposit_id', 'currency', 'owner_id', 'title', 'depositor', 'amount', 'percent', 'period', 'refill', 'capitalization',
        'withdrawal', 'start_date', 'status', 'created_at', 'updated_at',
    ];

    protected $hidden = [];
}
