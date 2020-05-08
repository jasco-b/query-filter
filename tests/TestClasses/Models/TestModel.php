<?php
/**
 * Created by PhpStorm.
 * User: jasurbek
 * Date: 5/8/20
 * Time: 1:48 PM
 */

namespace JascoB\QueryFilter\Tests\TestClasses\Models;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use JascoB\QueryFilter\Tests\TestClasses\Filters\TestQueryFilter;

/**
 * Class TestModel
 * @package JascoB\QueryFilter\Tests\TestClasses\Models
 * @method static Builder filter($request)
 */
class TestModel extends Model
{
    public function scopeFilter($query, $request)
    {
        return (new TestQueryFilter($query))->filter($request);
    }

    public static function getEloquentSqlWithBindings($query)
    {
        return vsprintf(str_replace('?', '%s', $query->toSql()), collect($query->getBindings())->map(function ($binding) {
            return is_numeric($binding) ? $binding : "'{$binding}'";
        })->toArray());
    }
}