<?php
/**
 * Created by PhpStorm.
 * User: jasurbek
 * Date: 2019-08-27
 * Time: 12:55
 */

namespace JascoB\QueryFilter\Interfaces;


interface IQueryFilter
{
    /**
     * @param $inputs array
     * @return mixed
     */
    public function filter($inputs);

    /**
     * Returns fields which can be filtered
     * @return array
     */
    public function getFilterableFields(): array ;
}
