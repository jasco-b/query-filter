<?php
/**
 * Created by PhpStorm.
 * User: jasurbek
 * Date: 5/8/20
 * Time: 1:49 PM
 */

namespace JascoB\QueryFilter\Tests\TestClasses\Filters;


use Illuminate\Database\Eloquent\Builder;
use JascoB\QueryFilter\QueryFilter;

class TestQueryFilter extends QueryFilter
{
    protected $filterableFields = ['title', 'description' => TestQueryFilterColumn::class];

    public function __construct(Builder $builder)
    {
        parent::__construct($builder);
        $this->initClosureFilter();
    }

    /**
     * @return void
     */
    public function initClosureFilter(): void
    {
        $this->filterableFields['status'] = function ($query, $value) {
            $query->where('status', $value);
        };
    }

    public function title($query, $value)
    {
        $query->where('title', 'like', "%$value%");
    }
}