<?php

namespace App\Http\Filters;

use Illuminate\Database\Eloquent\Builder;

class SpendFilter extends AbstractFilter {

    public const CATEGORY  = 'category';
    public const WALLET    = 'wallet';

    /**
     * @return array[]
     */
    protected function getCallbacks(): array
    {
        return [

            self::CATEGORY => [$this, 'category'],
            self::WALLET   => [$this, 'wallet'],
        ];
    }

    /**
     * @param Builder $builder
     * @param $value
     * @return void
     */
    public function category(Builder $builder, $value): void
    {
        $builder->where('category_id', $value);
    }

    /**
     * @param Builder $builder
     * @param $value
     * @return void
     */
    public function wallet(Builder $builder, $value): void
    {
        $builder->where('wallet_id', $value);
    }

}
