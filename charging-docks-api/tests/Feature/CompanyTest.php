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
        $payload = [
            'name' => 'ParentCompany1'
        ];

        $response = $this->json('post', '/api/v1/company', $payload);

        $response->assertStatus(201)
            ->assertJsonStructure(
                [
                    'name',
                    'updated_at',
                    'created_at',
                    'id',
                    'parent_company_id'
                ]
            );

    }
}
