<?php

use App\Models\Country;

beforeEach(function () {
    $this->basePath = 'api/countries';

    $this->headers = [
        'Accept' => 'application/json',
        'X-API-KEY' => config('services.api.key'),
    ];
});

it('returns not authorized if api key is missing', function () {
    $this->get($this->basePath)
        ->assertUnauthorized();
});

it('returns http code ok', function () {
    $this->withHeaders($this->headers)
        ->get($this->basePath)
        ->assertOk();
});

it('returns errors if code and name are missing when creating', function () {
    $this->withHeaders($this->headers)
        ->post($this->basePath)
        ->assertUnprocessable();
});

it('returns error if code is missing when creating', function () {
    $this->withHeaders($this->headers)
        ->post($this->basePath, [
            'name' => fake()->country(),
        ])
        ->assertUnprocessable();
});

it('returns error if name is missing when creating', function () {
    $this->withHeaders($this->headers)
        ->post($this->basePath, [
            'code' => fake()->countryCode(),
        ])
        ->assertUnprocessable();
});

it('creates', function () {
    $code = fake()->countryCode();
    $name = fake()->country();

    $this->withHeaders($this->headers)
        ->post($this->basePath, [
            'code' => $code,
            'name' => $name,
        ])
        ->assertCreated()
        ->assertJson([
            'data' => [
                'code' => $code,
                'name' => $name,
            ]
        ]);
});

it('shows', function () {
    $country = Country::factory()->create();

    $this->withHeaders($this->headers)
        ->get($this->basePath.'/'.$country->id)
        ->assertOk()
        ->assertExactJson([
            'data' => [
                'id' => $country->id,
                'code' => $country->code,
                'name' => $country->name,
                'created_at' => $country->created_at->toISOString(),
                'updated_at' => $country->updated_at->toISOString(),
                'deleted_at' => $country->deleted_at?->toISOString(),
            ]
        ]);
});

it('updates the code and the name', function () {
    $country = Country::factory()->create();
    $code = fake()->countryCode();
    $name = fake()->country();

    $this->withHeaders($this->headers)
        ->put($this->basePath.'/'.$country->id, [
            'code' => $code,
            'name' => $name,
        ])
        ->assertOk()
        ->assertJson([
            'data' => [
                'code' => $code,
                'name' => $name,
            ]
        ]);
});

it('updates the code', function () {
    $country = Country::factory()->create();
    $code = fake()->countryCode();

    $this->withHeaders($this->headers)
        ->put($this->basePath.'/'.$country->id, [
            'code' => $code,
        ])
        ->assertOk()
        ->assertJson([
            'data' => [
                'code' => $code,
                'name' => $country->name,
            ]
        ]);
});

it('updates the name', function () {
    $country = Country::factory()->create();
    $name = fake()->country();

    $this->withHeaders($this->headers)
        ->put($this->basePath.'/'.$country->id, [
            'name' => $name,
        ])
        ->assertOk()
        ->assertJson([
            'data' => [
                'code' => $country->code,
                'name' => $name,
            ]
        ]);
});

it('deletes', function () {
    $country = Country::factory()->create();

    $this->withHeaders($this->headers)
        ->delete($this->basePath.'/'.$country->id)
        ->assertNoContent();

    $this->assertSoftDeleted($country);
});