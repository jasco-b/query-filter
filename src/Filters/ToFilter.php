<?php
/**
 * Created by PhpStorm.
 * User: jasurbek
 * Date: 2019-08-12
 * Time: 15:47
 */

namespace JascoB\QueryFilter\Filters;


use JascoB\QueryFilter\Classes\FilterColumn;

class ToFilter extends FilterColumn
{
    public function apply($value)
    {
        return $this->builder->where('to', '>=', $value);
    }

}
