<?php

namespace App\Models\Deposit;

use App\Models\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DepositPayment extends Model {

    use HasFactory, Filterable;


    protected $table         = 'deposit_payments';

    protected $primaryKey    = 'payment_id';

    protected $keyType       = 'int';

    public    $incrementing  = true;

    public    $timestamps    = true;


    /**
     * @return BelongsTo
     */
    public function deposit(): BelongsTo
    {
        return $this->belongsTo(Deposit::class, 'deposit_id', 'deposit_id');
    }


    protected $with = [
        'deposit'
    ];

    protected $casts = [
        'created_at' => 'timestamp',
        'updated_at' => 'timestamp',
    ];

    protected $fillable = [
        'payment_id', 'deposit_id', 'amount', 'note', 'status', 'created_at', 'updated_at',
    ];

    protected $hidden = [];
}
