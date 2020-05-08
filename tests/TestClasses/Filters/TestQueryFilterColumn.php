<?php
/**
 * Created by PhpStorm.
 * User: jasurbek
 * Date: 5/8/20
 * Time: 1:50 PM
 */

namespace JascoB\QueryFilter\Tests\TestClasses\Filters;


use JascoB\QueryFilter\Classes\FilterColumn;

class TestQueryFilterColumn extends FilterColumn
{

    public function apply($value)
    {
        $this->builder->where('description', 'like', "%$value%");
    }
}