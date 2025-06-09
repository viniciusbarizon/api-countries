<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCountryRequest;
use App\Http\Requests\UpdateCountryRequest;
use App\Models\Country;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;
use \Illuminate\Http\Response;

class CountryController
{
    /**
     * Display a listing of the resource.
     *
     * Retrieves all countries, including soft-deleted records,
     * and returns them as a resource collection.
     *
     * @return ResourceCollection
     */
    public function index(): ResourceCollection
    {
        return Country::withTrashed()
            ->get()
            ->toResourceCollection();
    }

    /**
     * Store a newly created country in storage.
     *
     * Validates the incoming request using StoreCountryRequest,
     * creates a new Country record with the validated data,
     * and returns the country as a resource.
     *
     * @param  StoreCountryRequest  $request  The request instance containing validated country data.
     * @return JsonResource
     */
    public function store(StoreCountryRequest $request): JsonResource
    {
        $country = Country::create($request->validated());

        return $country->toResource();
    }

    /**
     * Display the specified resource.
     *
     * Retrieves a specific country by its ID, including soft-deleted records,
     * and returns it as a resource.
     *
     * @param  Country  $country  The country instance to be displayed.
     * @return JsonResource
     */
    public function show(Country $country): JsonResource
    {
        return Country::withTrashed()
            ->find($country->id)
            ->toResource();
    }

    /**
     * Update the specified resource in storage.
     *
     * Validates the incoming request using UpdateCountryRequest,
     * updates the specified Country record with the validated data,
     * and returns the updated country as a resource.
     *
     * @param  UpdateCountryRequest  $request  The request instance containing validated country data.
     * @param  Country  $country  The country instance to be updated.
     * @return JsonResource
     */
    public function update(UpdateCountryRequest $request, Country $country): JsonResource
    {
        $country->update($request->validated());

        return $country->toResource();
    }

    /**
     * Remove the specified resource from storage.
     *
     * Soft-deletes the specified Country record and returns a no content response.
     *
     * @param  Country  $country  The country instance to be deleted.
     * @return Response
     */
    public function destroy(Country $country): Response
    {
        $country->delete();

        return response()->noContent();
    }
}
