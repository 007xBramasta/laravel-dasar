<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Config as FacadesConfig;
use Tests\TestCase;

class FacadeTest extends TestCase
{
    public function testConfig()
    {
        $config = $this->app->make("config");
        $firstName3 = $config->get("contoh.author.first");

        $firstName1 = config("contoh.author.first");
        $firstName2 = FacadesConfig::get('contoh.author.first');

        self::assertEquals($firstName1, $firstName2);
        self::assertEquals($firstName1, $firstName3);

        // var_dump(FacadesConfig::all());
    }

    public function testFacadesMock()
    {
        FacadesConfig::shouldReceive('get')
        ->with('contoh.auhor.first')
        ->andReturn('Bram Keren');

        $firstName = FacadesConfig::get('contoh.author.first');

        self::assertEquals('Bram Keren', $firstName);
    }
}
