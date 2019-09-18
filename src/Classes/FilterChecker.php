<?php
/**
 * Created by PhpStorm.
 * User: jasurbek
 * Date: 2019-08-27
 * Time: 11:37
 */

namespace JascoB\QueryFilter\Classes;


use JascoB\QueryFilter\Interfaces\IQueryFilter;

/**
 * This class checks that a field is filterable
 *
 * Class FilterChecker
 * @package JascoB\QueryFilter\Classes
 */
class FilterChecker
{
    private $filterField;
    private $filterClass;
    private $filterableFields;

    /**
     * FilterChecker constructor.
     * @param $filterField string
     * @param IQueryFilter $filterClass
     */
    public function __construct($filterField, IQueryFilter $filterClass)
    {
        $this->filterField = $filterField;
        $this->filterClass = $filterClass;
        $this->filterableFields = $this->filterClass->getFilterableFields();
    }

    /**
     * check where a filed can be filtered
     * @return bool
     */
    public function check(): bool
    {
        if ($this->isFilterAll()) {
            return true;
        }

        if (in_array($this->filterField, $this->filterableFields)) {
            return true;
        }

        if (array_key_exists($this->filterField, $this->filterableFields)) {
            return true;
        }

        if ($this->hasMethod()) {
            return true;
        }

        return false;

    }

    /**
     * check whether has a filter class has a method
     *
     * @return bool
     */
    public function hasMethod(): bool
    {

        if (method_exists($this->filterClass, $this->filterField)) {
            return true;
        }

        return false;
    }

    /**
     * check whether the field has closure
     *
     * @return bool
     */
    public function isClosure(): bool
    {
        if (isset($this->filterableFields[$this->filterField])) {
            return $this->filterableFields[$this->filterField] instanceof \Closure;
        }
        return false;
    }

    /**
     * check whether a class has stand alone filter column class
     * @return bool
     */
    public function isFilterClass(): bool
    {
        if (isset($this->filterableFields[$this->filterField]) && is_string($this->filterableFields[$this->filterField])) {
            return class_exists($this->filterableFields[$this->filterField]);
        }
        return false;
    }

    /**
     * check if class use * and filters all fields
     * @return bool
     */
    public function isFilterAll(): bool
    {
        $fields = $this->filterableFields;
        if ($fields && isset($fields[0]) && $fields[0] === '*') {
            return true;
        }
        return false;
    }


}
