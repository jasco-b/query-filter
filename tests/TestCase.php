<?php
/**
 * Created by PhpStorm.
 * User: jasurbek
 * Date: 5/8/20
 * Time: 2:20 PM
 */

namespace JascoB\QueryFilter\Tests;



use Illuminate\Database\Schema\Blueprint;
use Illuminate\Foundation\Application;

class TestCase extends \Orchestra\Testbench\TestCase
{

    public function setUp():void
    {
        parent::setUp();
        $this->setUpDatabase($this->app);
    }

    public function setUpDatabase(Application $app)
    {
        $app['db']->connection()->getSchemaBuilder()->create('test_models', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('title');
            $table->string('description');
            $table->tinyInteger('status')->default(0);
        });
    }
}