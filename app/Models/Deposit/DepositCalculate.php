<?php

namespace App\Models\Deposit;

use App\Models\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DepositCalculate extends Model {

    use HasFactory, Filterable;


    protected $table         = 'deposit_calculates';

    protected $primaryKey    = 'deposit_id';

    protected $keyType       = 'int';

    public    $incrementing  = true;

    public    $timestamps    = true;


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
