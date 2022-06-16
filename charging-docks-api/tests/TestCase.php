<?php

namespace Tests;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Artisan;
use Faker\Factory;
use Faker\Generator;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, DatabaseMigrations;
    private  $faker;


    public function setUp():void
    {
        parent::setUp();
        $this->faker =  Factory::create();
        Artisan::call('db:seed');
    }

    public function __get($key) {

        if ($key === 'faker')
            return $this->faker;
        throw new Exception('Unknown Key Requested');
    }
}
