<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CompanyTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {
        $response = $this->get('/api/v1/company');

        $response->assertStatus(200);
    }

    public function testAddNewCompany()
    {
        $payload= [
            'name' => 'ParentCompany1'
        ];

        $this->json('post','/api/v1/company',$payload)
        ->assertStatus(201)
        ->assertJsonStructure([
            'data' => 
               [ 'id',
                'name',
                'parent_company_id',
                'created_at',
                'updated_at']
            
        ]);
    }
}
