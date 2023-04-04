<?php

namespace App\Http\Filters;

use Illuminate\Database\Eloquent\Builder;

class WalletFilter extends AbstractFilter {

    public const CURRENCY     = 'currency';

    /**
     * @return array[]
     */
    protected function getCallbacks(): array
    {
        return [

            self::CURRENCY => [$this, 'currency'],
        ];
    }

    /**
     * @param Builder $builder
     * @param $value
     * @return void
     */
    public function currency(Builder $builder, $value): void
    {
        $builder->where('currency_id', $value);
    }

}
