<?php
/**
 * Created by PhpStorm.
 * User: jasurbek
 * Date: 2019-08-12
 * Time: 15:30
 */

namespace JascoB\QueryFilter\Interfaces;

use Illuminate\Database\Eloquent\Builder;

interface IFilterColumn
{
    /**
     * IFilterColumn constructor.
     * @param Builder $builder
     * @param null $column
     */
    public function __construct(Builder $builder, $column = null);

    /**
     *  Applying query
     *  there should be a query
     *
     * ex: $this->builder->where(this->column, $value)
     *
     *
     * @param $value
     * @return mixed
     */
    public function apply($value);

}
