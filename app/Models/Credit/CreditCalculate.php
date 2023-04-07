<?php

namespace App\Models\Credit;

use App\Models\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CreditCalculate extends Model {

    use HasFactory, Filterable;


    protected $table         = 'credit_calculates';

    protected $primaryKey    = 'credit_id';

    protected $keyType       = 'int';

    public    $incrementing  = true;

    public    $timestamps    = true;


    protected $casts = [
        'created_at' => 'timestamp',
        'updated_at' => 'timestamp',
    ];

    protected $fillable = [
        'credit_id', 'owner_id', 'title', 'payment_type', 'currency', 'subject', 'amount', 'percent', 'period', 'payment',
        'created_at', 'updated_at',
    ];

    protected $hidden = [];
}
