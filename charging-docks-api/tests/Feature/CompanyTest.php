<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CompanyTest extends TestCase
{

    public function testAddNewCompany()
    {

        $payload = [
            'name' => $this->faker->name
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

    public function testGetAllCompanies()
    {

        $payloads = [
            ['name' => $this->faker->name],
            ['name' => $this->faker->name],
            ['name' => $this->faker->name]
        ];

        foreach ($payloads as $payload) {
            $response[] = json_decode($this->json('post', '/api/v1/company', $payload)->getContent());

        }

        $get_response = json_decode($this->json('get', '/api/v1/company')->getContent());

        $this->assertEquals(count($get_response), count($payloads));

    }

    public function testGetCompanyById()
    {

        $payload = [
            'name' => $this->faker->name,
        ];

        $post_response = json_decode($this->json('post', '/api/v1/company', $payload)->getContent());

        $id = $post_response->id;

        $get_response_json = $this->json('get', '/api/v1/company/' . $id);
        $get_response_json->assertJsonStructure([
            'id',
            'name',
            'parent_company_id',
            'created_at',
            'updated_at',
            'stations'
        ]);

        $get_response_obj = json_decode($get_response_json->getContent());
        $this->assertEquals($get_response_obj->name, $payload['name']);

    }

    public function testUpdateCompanyById()
    {
        // create
        $payload = [
            'name' => $this->faker->name,
        ];

        $post_response = json_decode($this->json('post', '/api/v1/company', $payload)->getContent());

        $id = $post_response->id;

        $updated_payload = [
            'name' => "updated_name",
        ];

        // update
        $get_response_json = $this->json('put', '/api/v1/company/' . $id, $updated_payload);
        $get_response_json->assertJsonStructure([
            'id',
            'name',
            'parent_company_id',
            'created_at',
            'updated_at',
        ]);

        $get_response_obj = json_decode($get_response_json->getContent());

        // test
        $this->assertEquals($get_response_obj->name, $updated_payload['name']);

    }

    public function testDeleteCompanyById()
    {
        // create
        $payload = [
            'name' => $this->faker->name,
        ];

        $post_response = json_decode($this->json('post', '/api/v1/company', $payload)->getContent());

        $id = $post_response->id;

        // delete
        $get_response_json = $this->json('delete', '/api/v1/company/' . $id);

        $get_response_obj = $get_response_json->getData();

        // tests
        $get_response_json->assertStatus(204);
        $this->assertEquals($get_response_obj->data, "Deleted successfully.");

        $get_response = $this->json('get', '/api/v1/company' . $id);
        $get_response->assertStatus(404);


    }
}
