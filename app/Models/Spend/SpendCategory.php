<?php

namespace App\Models\Spend;

use App\Models\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SpendCategory extends Model{

    use HasFactory, Filterable;


    protected $table         = 'spending_categories';

    protected $primaryKey    = 'category_id';

    protected $keyType       = 'int';


    public    $incrementing  = true;

    public    $timestamps    = true;


    protected $casts = [
        'created_at' => 'timestamp',
        'updated_at' => 'timestamp',
    ];

    protected $fillable = [
        'category_id', 'title', 'parent_id', 'created_at', 'updated_at',
    ];

    protected $hidden = [];
}
