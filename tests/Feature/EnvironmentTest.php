<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Env;
use Tests\TestCase;

class EnvironmentTest extends TestCase
{
    public function testGetEnv()
    {
        $youtube = env('YOUTUBE');

        self::assertEquals('Programmer Ganteng', $youtube);
    }

    public function testDefaultEnc()
    {
        $author = Env::get('AUTHOR', 'Bram');

        self::assertEquals('Bram', $author);
    }
}
