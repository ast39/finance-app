<?php

namespace App\Http\Filters;

use Illuminate\Database\Eloquent\Builder;

class UserFilter extends AbstractFilter {

    public const BY_NAME       = 'name';
    public const BY_EMAIL      = 'email';
    public const BY_DEPARTMENT = 'department_id';
    public const BY_POSITION   = 'position_id';
    public const BY_STATUS     = 'status';

    /**
     * @return array[]
     */
    protected function getCallbacks(): array
    {
        return [

            self::BY_NAME       => [$this, 'byName'],
            self::BY_EMAIL      => [$this, 'byEmail'],
            self::BY_DEPARTMENT => [$this, 'byDepartment'],
            self::BY_POSITION   => [$this, 'byPosition'],
            self::BY_STATUS     => [$this, 'byStatus'],
        ];
    }


    /**
     * @param Builder $builder
     * @param $value
     * @return void
     */
    public function byName(Builder $builder, $value): void
    {
        $builder->where('name', 'like', '%' . $value . '%');
    }

    /**
     * @param Builder $builder
     * @param $value
     * @return void
     */
    public function byEmail(Builder $builder, $value): void
    {
        $builder->where('email', 'like', '%' . $value . '%');
    }

    /**
     * @param Builder $builder
     * @param $value
     * @return void
     */
    public function byDepartment(Builder $builder, $value): void
    {
        $builder->where('department_id', $value);
    }

    /**
     * @param Builder $builder
     * @param $value
     * @return void
     */
    public function byPosition(Builder $builder, $value): void
    {
        $builder->where('position_id', $value);
    }

    /**
     * @param Builder $builder
     * @param $value
     * @return void
     */
    public function byStatus(Builder $builder, $value): void
    {
        $builder->where('status', $value);
    }
}
