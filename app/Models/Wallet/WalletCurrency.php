<?php

namespace App\Models\Wallet;

use App\Models\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WalletCurrency extends Model{

    use HasFactory, Filterable;


    protected $table         = 'wallet_currencies';

    protected $primaryKey    = 'currency_id';

    protected $keyType       = 'int';


    public    $incrementing  = true;

    public    $timestamps    = true;


    protected $casts = [
        'created_at' => 'timestamp',
        'updated_at' => 'timestamp',
    ];

    protected $fillable = [
        'currency_id', 'title', 'abbr', 'status', 'created_at', 'updated_at',
    ];

    protected $hidden = [];
}
