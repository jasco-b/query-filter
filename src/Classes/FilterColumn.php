<?php
/**
 * Created by PhpStorm.
 * User: jasurbek
 * Date: 2019-08-12
 * Time: 15:42
 */

namespace JascoB\QueryFilter\Classes;


use JascoB\QueryFilter\Interfaces\IFilterColumn;
use Illuminate\Database\Eloquent\Builder;

/**
 *
 * Class FilterColumn
 * @package JascoB\QueryFilter\Classes
 */
abstract class FilterColumn implements IFilterColumn
{
    protected $builder;
    protected $column;
    public function __construct(Builder $builder, $column = null)
    {
        $this->builder = $builder;
        $this->column = $column;
    }

    abstract public function apply($value);



}
