<?php

namespace App\Models\Credit;

use App\Models\Traits\Filterable;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Credit extends Model {

    use HasFactory, Filterable;


    protected $table         = 'credits';

    protected $primaryKey    = 'credit_id';

    protected $keyType       = 'int';

    public    $incrementing  = true;

    public    $timestamps    = true;


    /**
     * @return BelongsTo
     */
    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id', 'user_id');
    }

    /**
     * @return HasMany
     */
    public function payments(): HasMany
    {
        return $this->hasMany(CreditPayment::class, 'credit_id', 'credit_id');
    }


    protected $with = [
        'owner',
        'payments'
    ];

    protected $casts = [
        'created_at' => 'timestamp',
        'updated_at' => 'timestamp',
    ];

    protected $fillable = [
        'credit_id', 'owner_id', 'title', 'creditor', 'amount', 'percent', 'period', 'payment',
        'start_date', 'payment_date', 'status', 'created_at', 'updated_at',
    ];

    protected $hidden = [];
}
