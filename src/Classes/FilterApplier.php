<?php
/**
 * Created by PhpStorm.
 * User: jasurbek
 * Date: 2019-08-27
 * Time: 11:38
 */

namespace JascoB\QueryFilter\Classes;


use JascoB\QueryFilter\Interfaces\IQueryFilter;
use Illuminate\Database\Eloquent\Builder;
use Schema;

/**
 * This class is filter applier
 *
 * Class FilterApplier
 * @package JascoB\QueryFilter\Classes
 */
class FilterApplier
{
    private $builder;
    private $filterClass;
    private $filterField;
    private $filterableFields;

    /**
     * FilterApplier constructor.
     * @param Builder $builder
     * @param $filterField string
     * @param IQueryFilter $filterClass
     */
    public function __construct(Builder $builder, $filterField, IQueryFilter $filterClass)
    {
        $this->builder = $builder;
        $this->filterClass = $filterClass;
        $this->filterField = $filterField;
        $this->filterableFields = $filterClass->getFilterableFields();
    }

    public function apply($value)
    {
        $filterChecker = new FilterChecker($this->filterField, $this->filterClass);

        if (!$filterChecker->check()) {
            return;
        }

        if ($filterChecker->hasMethod()) {
            $this->applyMethod($value);
            return;
        }

        if ($filterChecker->isClosure()) {
            $this->applyClosure($value);
            return;
        }

        if ($filterChecker->isFilterClass()) {
            $this->applyClass($value);
            return;
        }


        if ($filterChecker->isFilterAll()) {
            $columns = Schema::getColumnListing($this->builder->getModel()->getTable());
            if (in_array($this->filterField, $columns)) {
                $this->builder->where($this->filterField, $value);
            }
        }

    }

    /**
     *  Applying class method
     *
     * @param $value string
     * @return mixed
     */
    protected function applyMethod($value)
    {
        return $this->filterClass->{$this->filterField}($this->builder, $value);
    }

    /**
     *  Applying filter column class
     *
     * @param $value string
     */
    protected function applyClass($value)
    {
        $obj = app()->makeWith($this->filterableFields[$this->filterField], [
            'builder' => $this->builder,
            'column' => $this->filterField,
        ]);
        $obj->apply($value);
    }

    /**
     *  Applying class
     *
     * @param $value string
     * @return mixed
     */
    protected function applyClosure($value)
    {
        return call_user_func($this->filterableFields[$this->filterField], $this->builder, $value);
    }
}
