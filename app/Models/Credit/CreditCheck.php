<?php

namespace App\Models\Credit;

use App\Models\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CreditCheck extends Model {

    use HasFactory, Filterable;


    protected $table         = 'credit_checks';

    protected $primaryKey    = 'calc_id';

    protected $keyType       = 'int';

    public    $incrementing  = true;

    public    $timestamps    = true;


    protected $casts = [
        'created_at' => 'timestamp',
        'updated_at' => 'timestamp',
    ];

    protected $fillable = [
        'calc_id', 'title', 'amount', 'percent', 'period', 'payment', 'created_at', 'updated_at',
    ];

    protected $hidden = [];
}
