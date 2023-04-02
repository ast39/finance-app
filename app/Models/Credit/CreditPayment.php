<?php

namespace App\Models\Credit;

use App\Models\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CreditPayment extends Model {

    use HasFactory, Filterable;


    protected $table         = 'credit_payments';

    protected $primaryKey    = 'payment_id';

    protected $keyType       = 'int';

    public    $incrementing  = true;

    public    $timestamps    = true;


    /**
     * @return BelongsTo
     */
    public function credit(): BelongsTo
    {
        return $this->belongsTo(Credit::class, 'credit_id', 'credit_id');
    }


    protected $with = [
        'credit'
    ];

    protected $casts = [
        'created_at' => 'timestamp',
        'updated_at' => 'timestamp',
    ];

    protected $fillable = [
        'payment_id', 'credit_id', 'amount', 'note', 'status', 'created_at', 'updated_at',
    ];

    protected $hidden = [];
}
