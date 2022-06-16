<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class StationTest extends TestCase
{
    public function testAddNewStation()
    {
        $company = [
            'name' => $this->faker->name,
        ];
        $response = $this->json('post', '/api/v1/company', $company);

        $station = [
            'name' => $this->faker->name,
            'address' => $this->faker->address,
            'latitude' => $this->faker->latitude,
            'longitude' => $this->faker->longitude,
            'parent_company_name' => $company['name']
        ];

        $response_create_station = $this->json('post', '/api/v1/station', $station);
        $response_create_station
            ->assertStatus(201)
            ->assertJsonStructure(
                [
                    'name',
                    'latitude',
                    'longitude',
                    'address',
                    'company_id',
                    'updated_at',
                    'created_at',
                    'id',
                ]
            );

    }

    public function testGetAllStations()
    {
        $companies = [
            ['name' => $this->faker->name],
            ['name' => $this->faker->name]
        ];

        foreach ($companies as $payload) {
            $response[] = json_decode($this->json('post', '/api/v1/company', $payload)->getContent());
        }

        foreach ($response as $res) {
            $station_payloads [] =
            $station = [
                'name' => $this->faker->name,
                'address' => $this->faker->address,
                'latitude' => $this->faker->latitude,
                'longitude' => $this->faker->longitude,
                'parent_company_name' => $res->name
            ];

        }

        foreach ($station_payloads as $station) {
            $response_create_stations[] = json_decode($this->json('post', '/api/v1/station', $station)->getContent());
        }

        $get_all_response = $this->json('get', '/api/v1/company');
        $get_all_response_data = json_decode($get_all_response->getContent());

        $get_all_response->assertStatus(200);
        $this->assertEquals(count($get_all_response_data), count($station_payloads));

    }

//
    public function testUpdateStationById()
    {
        // setup
        $company = [
            'name' => $this->faker->name,
        ];
        $post_response = json_decode($this->json('post', '/api/v1/company', $company)->getContent());
        $station = [
            'name' => $this->faker->name,
            'address' => $this->faker->address,
            'latitude' => $this->faker->latitude,
            'longitude' => $this->faker->longitude,
            'parent_company_name' => $company['name']
        ];

        $response_create_station = json_decode($this->json('post', '/api/v1/station', $station)->getContent());

        // update
        $updated_station = [
            'name' => $this->faker->name,
            'address' => $this->faker->address,
            'latitude' => $response_create_station->latitude,
            'longitude' => $response_create_station->longitude,
            'parent_company_name' => $company['name']
        ];

        $response_updated_station = $this->json('put', '/api/v1/station/' . $response_create_station->id, $updated_station);
        $response_updated_station_data = json_decode($response_updated_station->getContent());

        // test
        $response_updated_station
            ->assertStatus(200)
            ->assertJsonStructure([
                'id',
                'name',
                'address',
                'latitude',
                'longitude',
                'company_id',
                'created_at',
                'updated_at',
            ]);
        $this->assertEquals($response_updated_station_data->name, $updated_station['name']);
        $this->assertEquals($response_updated_station_data->address, $updated_station['address']);
        $this->assertEquals($response_updated_station_data->latitude, $response_create_station->latitude);
        $this->assertEquals($response_updated_station_data->longitude, $response_create_station->longitude);


    }

//
    public function testGetCompanyById()
    {
        // setup-create
        $company = [
            'name' => $this->faker->name,
        ];
        $post_response = json_decode($this->json('post', '/api/v1/company', $company)->getContent());
        $station = [
            'name' => $this->faker->name,
            'address' => $this->faker->address,
            'latitude' => $this->faker->latitude,
            'longitude' => $this->faker->longitude,
            'parent_company_name' => $company['name']
        ];

        $response_create_station = json_decode($this->json('post', '/api/v1/station', $station)->getContent());

        $station_id = $response_create_station->id;

        // get action
        $get_response_json = $this->json('get', '/api/v1/station/' . $station_id);

        // test
        $get_response_json
            ->assertStatus(200)
            ->assertJsonStructure(
                [
                    'id',
                    'name',
                    'address',
                    'latitude',
                    'longitude',
                    'company_id',
                    'created_at',
                    'updated_at',
                ]
            );
        $this->assertEquals($response_create_station, json_decode($get_response_json->getContent()));
    }

    public function testDeleteStationById()
    {
        // setup-create
        $company = [
            'name' => $this->faker->name,
        ];
        $post_response = json_decode($this->json('post', '/api/v1/company', $company)->getContent());
        $station = [
            'name' => $this->faker->name,
            'address' => $this->faker->address,
            'latitude' => $this->faker->latitude,
            'longitude' => $this->faker->longitude,
            'parent_company_name' => $company['name']
        ];

        $response_create_station = json_decode($this->json('post', '/api/v1/station', $station)->getContent());

        $station_id = $response_create_station->id;

        // delete action
        $delete_response_json = $this->json('delete', '/api/v1/station/' . $station_id);
        $delete_response_obj = $delete_response_json->getData();
        $get_response = json_decode($this->json('get', '/api/v1/station')->getContent());

        // tests
        $this->assertEquals($delete_response_obj->data, "Deleted successfully.");
        $this->assertEmpty($get_response);

    }
}
