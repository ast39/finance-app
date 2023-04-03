<?php

namespace App\Models\Spend;

use App\Models\Traits\Filterable;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Spend extends Model{

    use HasFactory, Filterable;


    protected $table         = 'spends';

    protected $primaryKey    = 'spend_id';

    protected $keyType       = 'int';


    public    $incrementing  = true;

    public    $timestamps    = true;


    /**
     * @return BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(SpendCategory::class, 'category_id', 'category_id');
    }

    /**
     * @return BelongsTo
     */
    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id', 'id');
    }


    protected $with = [
        'category',
        'owner'
    ];

    protected $casts = [
        'created_at' => 'timestamp',
        'updated_at' => 'timestamp',
    ];

    protected $fillable = [
        'spend_id', 'owner_id', 'category_id', 'amount', 'note', 'status', 'created_at', 'updated_at',
    ];

    protected $hidden = [];
}
