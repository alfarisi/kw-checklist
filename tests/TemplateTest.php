<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;
use App\User;

class TemplateTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->get('/');

        $this->assertEquals(
            $this->app->version(), $this->response->getContent()
        );
    }
    
    public function testIndex()
    {
        $user = new User;
        
        $this->actingAs($user)->get('/checklists/templates');
        $this->assertResponseOk();
        $this->seeJsonStructure([
            'links',
            'data',
            'meta',
        ]);

    }
    
    public function testDetail()
    {
        $user = new User;
        
        $this->actingAs($user)->get('/checklists/templates/3');
        $this->assertResponseOk();
        $this->seeJsonStructure([
            'data'
        ]);

    }
}
