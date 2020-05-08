<?php
/**
 * Created by PhpStorm.
 * User: jasurbek
 * Date: 5/8/20
 * Time: 1:44 PM
 */

namespace JascoB\QueryFilter\Tests;


use JascoB\QueryFilter\Tests\TestClasses\Models\TestModel;

class FilterTest extends \Orchestra\Testbench\TestCase
{
    public function test_query_filter_with_method()
    {
        $request = ['title' => 'test'];
        $query = TestModel::filter($request);

        $generatedSql = TestModel::getEloquentSqlWithBindings($query);

        $sql = "select * from `test_models` where `title` like '%test%'";
        $this->assertEquals($sql, $generatedSql);
    }


    public function test_closure_type_filtering()
    {
        $request = ['status' => 1];
        $query = TestModel::filter($request);

        $generatedSql = TestModel::getEloquentSqlWithBindings($query);

        $sql = "select * from `test_models` where `status` = 1";
        $this->assertEquals($sql, $generatedSql);
    }

    public function test_stand_alone_class_filter()
    {
        $request = ['description' => 'no idea'];
        $query = TestModel::filter($request);

        $generatedSql = TestModel::getEloquentSqlWithBindings($query);

        $sql = "select * from `test_models` where `description` like '%no idea%'";
        $this->assertEquals($sql, $generatedSql);
    }

    public function test_non_existing_field()
    {
        $request = ['test' => 'no filter'];
        $query = TestModel::filter($request);

        $generatedSql = TestModel::getEloquentSqlWithBindings($query);

        $sql = "select * from `test_models`";
        $this->assertEquals($sql, $generatedSql);
    }

    public function test_non_existing_but_not_filterable_field()
    {
        $request = ['created_at' => '2020-06-08 12:12:12'];
        $query = TestModel::filter($request);

        $generatedSql = TestModel::getEloquentSqlWithBindings($query);

        $sql = "select * from `test_models`";
        $this->assertEquals($sql, $generatedSql);
    }

    public function test_several_filterable_fields()
    {
        $request = ['description' => 'no idea','title'=>'Hi there'];
        $query = TestModel::filter($request);

        $generatedSql = TestModel::getEloquentSqlWithBindings($query);


        $sql = "select * from `test_models` where `description` like '%no idea%' and `title` like '%Hi there%'";
        $this->assertEquals($sql, $generatedSql);
    }
}