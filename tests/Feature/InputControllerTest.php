<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class InputControllerTest extends TestCase
{
    public function testInput()
    {
        $this->get('/input/hello?name=Bram')
            ->assertSeeText('Hello Bram');

        $this->post('/input/hello', [
            'name' => 'Bram'
        ])->assertSeeText('Hello Bram');
    }

    public function testInputNested()
    {
        $this->post('/input/hello/first', [
            "name" => [
                "first" => "Bramasta",
                "last" => "Albatio"
            ]
        ])->assertSeeText("Hello Bramasta");
    }

    public function testInputAll()
    {
        $this->post('/input/hello/input ', [
            "name" => [
                "first" => "Bramasta",
                "last" => "Albatio"
            ]
        ])->assertSeeText("name")->assertSeeText("first")
          ->assertSeeText("last")->assertSeeText("Bramasta")
          ->assertSeeText("Albatio");
    }

    public function testInputArray()
    {
        $this->post('/input/hello/array', [
            "products" => [
                [
                    "name" => "Mac Book Pro",
                    "price" => 15000000
                ],
                [
                    "name" => "Iphone 13",
                    "price" => 10000000
                ]
            ]
        ])->assertSeeText("Mac Book Pro")->assertSeeText("Iphone 13");
    }

    public function testInputType()
    {
        $this->post('/input/type', [
            'name' => 'Bramasta',
            'married' => 'true',
            'birth_date' => '2002-06-26'
        ])->assertSeeText('Bramasta')->assertSeeText('true')->assertSeeText('2002-06-26');
    }

    public function testFilterOnly()
    {
        $this->post('/input/filter/only', [
            "name" => [
                "first" => "Bramasta",
                "middle" => "Albatio",
                "last" => "Haryono"
            ]
        ])->assertSeeText("Bramasta")->assertSeeText("Haryono")->assertDontSeeText("Albatio");
    }

    public function testFilterExcept()
    {
        $this->post('/input/filter/except', [
            "username" => "bramasta",   
            "password" => "rahasia",
            "admin" => "true"
        ])->assertSeeText("bramasta")->assertSeeText("rahasia")->assertDontSeeText("true");
    }    

    public function testFilterMerge()
    {
        $this->post('/input/filter/merge', [
            "username" => "bramasta",
            "password" => "rahasia",
            "admin" => "true"
        ])->assertSeeText("bramasta")->assertSeeText("rahasia")->assertSeeText("admin")->assertSeeText("false");
    }    
}
