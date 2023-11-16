<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ViewTest extends TestCase
{
    public function testView()
    {
      $this->get('/hello')
      ->assertSeeText('Hello Bram');

      $this->get('/hello-again')
      ->assertSeeText('Hello Bram');
    }

    public function testNested()
    {
        $this->get('/hello-world')
        ->assertSeeText('World Bram');
    }

    public function testTemplate()
    {
        $this->view('hello', ['name' => 'Bram'])
        ->assertSeeText('Hello Bram');

        $this->view('hello.world', ['name' => 'Bram'])
        ->assertSeeText('World Bram');
    }
}
