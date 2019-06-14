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
        
        $this->actingAs($user)->get('/checklists/templates/4');
        $this->assertResponseOk();
        $this->seeJsonStructure([
            'data'
        ]);

    }
    
    public function testDelete()
    {
        $user = new User;
        
        $this->actingAs($user)->delete('/checklists/templates/6');
        $this->assertEquals(204, $this->response->status());

    }
}
