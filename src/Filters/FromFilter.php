<?php
/**
 * Created by PhpStorm.
 * User: jasurbek
 * Date: 2019-08-12
 * Time: 15:39
 */

namespace JascoB\QueryFilter\Filters;


use JascoB\QueryFilter\Classes\FilterColumn;

class FromFilter extends FilterColumn
{
    public function apply($value)
    {
       return $this->builder->where('from', '<=', $value);
    }

}
