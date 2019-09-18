<?php
/**
 * Created by PhpStorm.
 * User: jasurbek
 * Date: 2019-08-12
 * Time: 15:20
 */

namespace JascoB\QueryFilter;


use JascoB\QueryFilter\Classes\FilterApplier;
use JascoB\QueryFilter\Interfaces\IQueryFilter;
use Illuminate\Database\Eloquent\Builder;

class QueryFilter implements IQueryFilter
{
    /**
     * @var Builder $builder
     */
    protected $builder;

    /**
     *  Fields for filtering
     *  * means all fields can be filtered
     *
     * @var array $filterableFields
     */
    protected $filterableFields = ['*'];


    /**
     * QueryFilter constructor.
     * @param Builder $builder
     */
    public function __construct(Builder $builder)
    {
        $this->builder = $builder;
    }

    /**
     *  Method for filtering
     *  Request array is needed
     *
     * @param $inputs array
     * @return Builder
     */
    public function filter($inputs): Builder
    {
        foreach ($inputs as $inputField => $inputValue) {
            $this->applyFilter($inputField, $inputValue);
        }
        return $this->builder;
    }

    /**
     *
     * @return array
     */
    public function getFilterableFields(): array
    {
        return $this->filterableFields;
    }

    /**
     * @param $inputField string
     * @param $inputValue string|\Closure
     */
    protected function applyFilter($inputField, $inputValue)
    {
        (new FilterApplier($this->builder, $inputField, $this))
            ->apply($inputValue);
    }


}
